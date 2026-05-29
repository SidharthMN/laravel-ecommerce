<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="space-y-8">
            <header class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.24em] text-brand-cyan">Admin Dashboard</p>
                    <h1 class="mt-3 text-3xl font-black text-brand-text">Store management hub</h1>
                    <p class="mt-3 text-sm text-brand-text-secondary">Manage products, orders, users, categories, inventory, banners, coupons, analytics, and reviews.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.products') }}" class="btn-primary">Manage Products</a>
                    <a href="{{ route('admin.orders') }}" class="btn-secondary">Manage Orders</a>
                    <a href="{{ route('admin.users') }}" class="btn-secondary">Manage Users</a>
                </div>
            </header>

            @if(session('success'))
                <div class="rounded-lg border border-brand-cyan/50 bg-brand-cyan/10 px-5 py-4 text-sm font-semibold text-brand-cyan">{{ session('success') }}</div>
            @endif

            <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                @foreach([
                    ['label' => 'Products', 'value' => $totalProducts],
                    ['label' => 'Orders', 'value' => $totalOrders],
                    ['label' => 'Users', 'value' => $totalUsers],
                    ['label' => 'Revenue', 'value' => '₹' . number_format($revenue, 2)],
                    ['label' => 'Pending Orders', 'value' => $pendingOrders],
                ] as $metric)
                    <div class="rounded-lg border border-slate-700 bg-black p-5 shadow-[0_18px_55px_rgba(0,0,0,0.35)]">
                        <p class="text-xs font-black uppercase tracking-[0.16em] text-brand-text-secondary">{{ $metric['label'] }}</p>
                        <p class="mt-4 text-3xl font-black text-white">{{ $metric['value'] }}</p>
                    </div>
                @endforeach
            </section>

            <section class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-lg border border-slate-700 bg-brand-gray p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-black text-brand-text">Sales Analytics</h2>
                        <span class="text-sm text-brand-text-secondary">Monthly sales</span>
                    </div>
                    <div class="mt-6 space-y-4">
                        @forelse($monthlyRevenue as $row)
                            @php $width = $revenue > 0 ? min(100, (($row->revenue / max($revenue, 1)) * 100) * 4) : 0; @endphp
                            <div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-brand-text">{{ $row->month }}</span>
                                    <span class="font-semibold text-brand-cyan">₹{{ number_format($row->revenue, 2) }}</span>
                                </div>
                                <div class="mt-2 h-3 overflow-hidden rounded-full bg-slate-800">
                                    <div class="h-full rounded-full bg-brand-gradient" style="width: {{ $width }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-brand-text-secondary">No sales yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-lg border border-slate-700 bg-brand-gray p-6">
                    <h2 class="text-xl font-black text-brand-text">Top Products</h2>
                    <div class="mt-5 space-y-3">
                        @forelse($topProducts as $name => $quantity)
                            <div class="flex justify-between rounded-lg border border-slate-700 bg-black/40 px-4 py-3">
                                <span class="font-semibold text-brand-text">{{ $name }}</span>
                                <span class="text-brand-cyan">{{ $quantity }} sold</span>
                            </div>
                        @empty
                            <p class="text-brand-text-secondary">Top products appear after orders are placed.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-lg border border-slate-700 bg-brand-gray p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-black text-brand-text">Inventory / Stock Control</h2>
                        <a href="{{ route('admin.products') }}" class="text-sm font-semibold text-brand-cyan hover:text-white">Manage stock</a>
                    </div>
                    <div class="mt-5 space-y-3">
                        @forelse($lowStockProducts as $product)
                            <div class="flex justify-between rounded-lg border border-amber-300/40 bg-amber-300/10 px-4 py-3">
                                <span class="font-semibold text-brand-text">{{ $product->name }}</span>
                                <span class="font-black text-amber-200">{{ $product->stock }} left</span>
                            </div>
                        @empty
                            <p class="text-brand-text-secondary">No low stock products.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-lg border border-slate-700 bg-brand-gray p-6">
                    <h2 class="text-xl font-black text-brand-text">Latest Orders</h2>
                    <div class="mt-5 space-y-3">
                        @forelse($orders as $order)
                            <div class="flex flex-col gap-2 rounded-lg border border-slate-700 bg-black/40 p-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="font-black text-brand-text">#{{ $order->id }} {{ $order->customer_name }}</p>
                                    <p class="text-sm text-brand-text-secondary">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div class="text-sm sm:text-right">
                                    <p class="font-semibold text-brand-cyan">{{ $order->status }}</p>
                                    <p class="font-black text-brand-text">₹{{ number_format($order->total_price, 2) }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-brand-text-secondary">No orders yet.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-lg border border-slate-700 bg-brand-gray p-6">
                    <h2 class="text-xl font-black text-brand-text">Category Management</h2>
                    <form action="{{ route('admin.categories.store') }}" method="POST" class="mt-5 flex gap-3">
                        @csrf
                        <input name="name" class="input-field" placeholder="Streetwear">
                        <button class="btn-primary">Add</button>
                    </form>
                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach($categories as $category)
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-lg border border-slate-700 bg-black px-3 py-2 text-sm text-brand-text hover:border-red-300">{{ $category->name }}</button>
                            </form>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-lg border border-slate-700 bg-brand-gray p-6">
                    <h2 class="text-xl font-black text-brand-text">Banner Management</h2>
                    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="mt-5 space-y-3">
                        @csrf
                        <input name="title" class="input-field" placeholder="Summer Sale">
                        <input name="subtitle" class="input-field" placeholder="New drops are live">
                        <input name="image" type="file" class="w-full rounded-lg border border-slate-700 bg-black px-3 py-2 text-brand-text-secondary" accept="image/*">
                        <label class="flex items-center gap-2 text-sm text-brand-text-secondary"><input type="checkbox" name="is_active" value="1" checked> Active</label>
                        <button class="btn-primary w-full">Add Banner</button>
                    </form>
                    <div class="mt-5 space-y-2">
                        @foreach($banners as $banner)
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="flex justify-between rounded-lg border border-slate-700 bg-black px-3 py-2">
                                @csrf
                                @method('DELETE')
                                <span class="text-sm text-brand-text">{{ $banner->title }}</span>
                                <button class="text-sm text-red-200">Delete</button>
                            </form>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-lg border border-slate-700 bg-brand-gray p-6">
                    <h2 class="text-xl font-black text-brand-text">Coupon / Discount System</h2>
                    <form action="{{ route('admin.coupons.store') }}" method="POST" class="mt-5 space-y-3">
                        @csrf
                        <input name="code" class="input-field" placeholder="SID10">
                        <input name="discount_percent" type="number" min="1" max="90" class="input-field" placeholder="10">
                        <label class="flex items-center gap-2 text-sm text-brand-text-secondary"><input type="checkbox" name="is_active" value="1" checked> Active</label>
                        <button class="btn-primary w-full">Add Coupon</button>
                    </form>
                    <div class="mt-5 space-y-2">
                        @foreach($coupons as $coupon)
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="flex justify-between rounded-lg border border-slate-700 bg-black px-3 py-2">
                                @csrf
                                @method('DELETE')
                                <span class="text-sm text-brand-text">{{ $coupon->code }} - {{ $coupon->discount_percent }}%</span>
                                <button class="text-sm text-red-200">Delete</button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="rounded-lg border border-slate-700 bg-brand-gray p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-black text-brand-text">Reviews Moderation</h2>
                    <span class="text-sm text-brand-text-secondary">Approve reviews or delete spam</span>
                </div>
                <div class="mt-5 grid gap-4 lg:grid-cols-2">
                    @forelse($reviews as $review)
                        <div class="rounded-lg border border-slate-700 bg-black/40 p-4">
                            <div class="flex justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-brand-text">{{ $review->product->name ?? 'Product' }}</p>
                                    <p class="text-sm text-brand-text-secondary">{{ $review->user->name ?? 'User' }} - {{ $review->rating }}/5</p>
                                </div>
                                <span class="text-xs font-semibold {{ $review->is_approved ? 'text-emerald-300' : 'text-amber-200' }}">{{ $review->is_approved ? 'Approved' : 'Hidden' }}</span>
                            </div>
                            <p class="mt-3 text-sm text-brand-text-secondary">{{ $review->comment }}</p>
                            <div class="mt-4 flex gap-3">
                                <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_approved" value="{{ $review->is_approved ? 0 : 1 }}">
                                    <button class="btn-secondary">{{ $review->is_approved ? 'Hide' : 'Approve' }}</button>
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-red-400/70 px-4 py-2 text-sm font-semibold text-red-200 hover:bg-red-500 hover:text-white">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-brand-text-secondary">No reviews yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
