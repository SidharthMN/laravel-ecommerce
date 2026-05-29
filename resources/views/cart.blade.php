<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="space-y-6">
            <header class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.28em] text-brand-text-secondary">Shopping cart</p>
                    <h1 class="mt-2 text-3xl font-semibold text-brand-text">Your order is ready to review</h1>
                </div>
                <a href="{{ url('/products') }}" class="btn-secondary">Continue shopping</a>
            </header>

            @if(session('error'))
                <div class="rounded-lg border border-red-400/70 bg-red-500/10 px-5 py-4 text-sm font-semibold text-red-100">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="rounded-lg border border-brand-cyan/50 bg-brand-cyan/10 px-5 py-4 text-sm font-semibold text-brand-cyan">
                    {{ session('success') }}
                </div>
            @endif

            @php $total = 0; @endphp

            @if(session('cart') && count(session('cart')))
                <div class="grid gap-6 md:grid-cols-[1.5fr_0.9fr]">
                    <div class="space-y-4">
                        @foreach(session('cart') as $id => $details)
                            <div class="card p-6 grid gap-6 sm:grid-cols-[120px_1fr] items-start">
                                <div class="overflow-hidden rounded-3xl bg-brand-dark border border-slate-700">
                                    <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="h-full w-full object-cover" />
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <h2 class="text-xl font-semibold text-brand-text">{{ $details['name'] }}</h2>
                                        <p class="mt-2 text-sm leading-6 text-brand-text-secondary">Price: ₹{{ number_format($details['price'], 2) }}</p>
                                        <p class="text-sm text-brand-cyan">Subtotal: ₹{{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                                        @isset($details['stock'])
                                            <p class="mt-1 text-xs text-brand-text-secondary">Available stock: {{ $details['stock'] }}</p>
                                        @endisset
                                    </div>
                                    <div class="flex flex-wrap gap-3 items-center">
                                        <form action="{{ url('/cart/decrease/' . $id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            <button type="submit" class="btn-secondary">-</button>
                                        </form>
                                        <span class="rounded-full bg-brand-gray px-4 py-2 text-sm font-semibold text-brand-text">{{ $details['quantity'] }}</span>
                                        <form action="{{ url('/cart/increase/' . $id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            <button type="submit" class="btn-secondary">+</button>
                                        </form>
                                        <form action="{{ url('/cart/remove/' . $id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            <button type="submit" class="btn-secondary">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @php $total += $details['price'] * $details['quantity']; @endphp
                        @endforeach
                    </div>

                    <aside class="card p-6 space-y-6">
                        <div>
                            <p class="text-sm uppercase tracking-[0.24em] text-brand-text-secondary">Order summary</p>
                            <p class="mt-3 text-3xl font-semibold text-brand-text">₹{{ number_format($total, 2) }}</p>
                        </div>
                        <div class="space-y-3 rounded-3xl bg-brand-gray p-5 text-brand-text-secondary">
                            <div class="flex items-center justify-between">
                                <span>Items</span>
                                <span>{{ count(session('cart')) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                        </div>
                        <a href="{{ url('/checkout') }}" class="btn-primary w-full text-center">Proceed to Checkout</a>
                    </aside>
                </div>
            @else
                <div class="card p-10 text-center">
                    <h2 class="text-2xl font-semibold text-brand-text">Your cart is empty</h2>
                    <p class="mt-3 text-brand-text-secondary">Add products to your cart before checking out.</p>
                    <a href="{{ url('/products') }}" class="btn-primary mt-6 inline-flex">Browse products</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
