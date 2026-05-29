<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <header class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.24em] text-brand-cyan">Admin Orders</p>
                    <h1 class="mt-3 text-3xl font-black text-brand-text">Manage customer orders</h1>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Admin Dashboard</a>
            </header>

            @if(session('success'))
                <div class="rounded-lg border border-brand-cyan/50 bg-brand-cyan/10 px-5 py-4 text-sm font-semibold text-brand-cyan">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-lg border border-slate-700 bg-brand-gray">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700">
                        <thead class="bg-slate-950/50">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.16em] text-brand-text-secondary">Order</th>
                                <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.16em] text-brand-text-secondary">Customer</th>
                                <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.16em] text-brand-text-secondary">Items</th>
                                <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.16em] text-brand-text-secondary">Status</th>
                                <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.16em] text-brand-text-secondary">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @forelse($orders as $order)
                                <tr>
                                    <td class="px-5 py-4 align-top">
                                        <p class="font-black text-brand-text">#{{ $order->id }}</p>
                                        <p class="text-sm text-brand-text-secondary">{{ $order->created_at->format('M d, Y') }}</p>
                                        <p class="mt-2 font-black text-brand-cyan">₹{{ number_format($order->total_price, 2) }}</p>
                                    </td>
                                    <td class="px-5 py-4 align-top text-sm text-brand-text-secondary">
                                        <p class="font-semibold text-brand-text">{{ $order->customer_name }}</p>
                                        <p>{{ $order->customer_email }}</p>
                                        <p>{{ $order->customer_phone }}</p>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="space-y-1 text-sm text-brand-text-secondary">
                                            @foreach($order->products ?? [] as $item)
                                                <p>{{ $item['name'] ?? 'Product' }} x {{ $item['quantity'] ?? 1 }}</p>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-3">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="input-field min-w-36 py-2 text-sm">
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn-secondary w-full">Update</button>
                                        </form>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-red-400/70 px-4 py-2 text-sm font-semibold text-red-200 transition hover:bg-red-500 hover:text-white">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-brand-text-secondary">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
