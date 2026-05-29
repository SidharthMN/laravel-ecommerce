<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <header>
                <p class="text-sm font-bold uppercase tracking-[0.24em] text-brand-cyan">Order History</p>
                <h1 class="mt-3 text-3xl font-black text-brand-text">Your orders</h1>
                <p class="mt-3 text-sm text-brand-text-secondary">Track status, items, totals, and timestamps for every order.</p>
            </header>

            @if($orders->count())
                <div class="space-y-5">
                    @foreach($orders as $order)
                        @php
                            $statusClass = match($order->status) {
                                'Delivered' => 'border-emerald-400/60 text-emerald-300 bg-emerald-400/10',
                                'Shipped' => 'border-cyan-400/60 text-cyan-300 bg-cyan-400/10',
                                default => 'border-amber-300/60 text-amber-200 bg-amber-300/10',
                            };
                        @endphp
                        <article class="rounded-lg border border-slate-700 bg-brand-gray p-6">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <h2 class="text-xl font-black text-brand-text">Order #{{ $order->id }}</h2>
                                        <span class="rounded-lg border px-3 py-1 text-xs font-black uppercase tracking-[0.14em] {{ $statusClass }}">{{ $order->status }}</span>
                                    </div>
                                    <p class="mt-2 text-sm text-brand-text-secondary">Placed {{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <p class="text-2xl font-black text-brand-cyan">₹{{ number_format($order->total_price, 2) }}</p>
                            </div>

                            <div class="mt-5 grid gap-4 lg:grid-cols-[1.2fr_0.8fr]">
                                <div class="rounded-lg border border-slate-700 bg-slate-950/35 p-4">
                                    <p class="text-sm font-bold uppercase tracking-[0.16em] text-brand-text-secondary">Items</p>
                                    <div class="mt-3 space-y-2">
                                        @foreach($order->products ?? [] as $item)
                                            <div class="flex items-center justify-between gap-3 text-sm">
                                                <span class="text-brand-text">{{ $item['name'] ?? 'Product' }} x {{ $item['quantity'] ?? 1 }}</span>
                                                <span class="font-semibold text-brand-text-secondary">₹{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="rounded-lg border border-slate-700 bg-slate-950/35 p-4 text-sm text-brand-text-secondary">
                                    <p class="font-bold uppercase tracking-[0.16em]">Shipping</p>
                                    <p class="mt-3 text-brand-text">{{ $order->shipping_address ?: 'Address not saved' }}</p>
                                    <p>{{ $order->shipping_city }}</p>
                                    <p>{{ $order->customer_phone }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="rounded-lg border border-slate-700 bg-brand-gray p-10 text-center">
                    <h2 class="text-2xl font-black text-brand-text">No orders yet</h2>
                    <p class="mt-3 text-brand-text-secondary">Your order history will appear here after checkout.</p>
                    <a href="{{ url('/products') }}" class="btn-primary mt-6 inline-flex">Start Shopping</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
