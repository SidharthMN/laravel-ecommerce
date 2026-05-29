<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid gap-8 md:grid-cols-[1.1fr_0.9fr]">
            <main class="space-y-6">
                <div class="card p-8">
                    <p class="text-sm uppercase tracking-[0.24em] text-brand-text-secondary">Checkout</p>
                    <h1 class="mt-3 text-3xl font-semibold text-brand-text">Complete your order</h1>
                    <p class="mt-3 text-brand-text-secondary">Fill in your details to place your order. We'll take care of the rest.</p>
                </div>

                @if(session('error'))
                    <div class="rounded-lg border border-red-400/70 bg-red-500/10 px-5 py-4 text-sm font-semibold text-red-100">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ url('/place-order') }}" method="POST" class="rounded-lg border border-slate-700 bg-black p-8 shadow-[0_25px_80px_rgba(0,0,0,0.5)] space-y-6">
                    @csrf

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-brand-text-secondary" for="name">Name</label>
                            <input id="name" name="name" type="text" class="input-field bg-black" value="{{ old('name', auth()->user()->name) }}" placeholder="John Doe" required>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-brand-text-secondary" for="email">Email</label>
                            <input id="email" name="email" type="email" class="input-field bg-black" value="{{ old('email', auth()->user()->email) }}" placeholder="john@example.com" required>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-brand-text-secondary" for="address">Address</label>
                        <input id="address" name="address" type="text" class="input-field bg-black" placeholder="123 Main Street" required>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-brand-text-secondary" for="city">City</label>
                            <input id="city" name="city" type="text" class="input-field bg-black" placeholder="City" required>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-brand-text-secondary" for="phone">Phone</label>
                            <input id="phone" name="phone" type="text" class="input-field bg-black" placeholder="+91 98765 43210" required>
                        </div>
                    </div>

                    <div>
                        <p class="mb-2 block text-sm font-medium text-brand-text-secondary">Payment</p>
                        <div class="grid gap-6 sm:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-sm text-brand-text-secondary" for="card_number">Card number</label>
                                <input id="card_number" name="card_number" type="text" inputmode="numeric" autocomplete="cc-number" class="input-field bg-black" placeholder="4242 4242 4242 4242" required>
                            </div>
                            <div>
                                <label class="mb-2 block text-sm text-brand-text-secondary" for="card_expiry">Expiry (MM/YY)</label>
                                <input id="card_expiry" name="card_expiry" type="text" autocomplete="cc-exp" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" class="input-field bg-black" placeholder="MM/YY" required>
                            </div>
                            <div>
                                <label class="mb-2 block text-sm text-brand-text-secondary" for="card_cvc">CVC</label>
                                <input id="card_cvc" name="card_cvc" type="text" inputmode="numeric" autocomplete="cc-csc" class="input-field bg-black" placeholder="123" required>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-brand-text-secondary">We do not store full card details. For production, integrate a PCI-compliant gateway.</p>
                    </div>

                    <button type="submit" class="btn-primary w-full">Place Order</button>
                </form>
            </main>

            <aside class="space-y-6">
                <div class="card p-8">
                    <h2 class="text-2xl font-semibold text-brand-text">Order details</h2>
                    <p class="mt-3 text-brand-text-secondary">We only need a few details to create your order. Your information stays safe and secure.</p>
                    <div class="mt-6 rounded-3xl bg-brand-gray p-5 text-brand-text-secondary">
                        <p class="text-sm font-semibold text-brand-text">Need help?</p>
                        <p class="mt-2 text-sm">Contact support if you need assistance with your order.</p>
                    </div>
                </div>
                @if(session('cart') && count(session('cart')))
                    <div class="card p-6">
                        <p class="text-sm uppercase tracking-[0.24em] text-brand-text-secondary">Cart summary</p>
                        <div class="mt-4 space-y-3">
                            @php $subtotal = 0; @endphp
                            @foreach(session('cart') as $item)
                                @php $subtotal += $item['price'] * $item['quantity']; @endphp
                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-sm text-brand-text-secondary">{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                                    <span class="text-sm font-semibold text-brand-text">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </div>
                            @endforeach
                            <div class="border-t border-slate-700 pt-4 flex items-center justify-between text-lg font-semibold text-brand-text">
                                <span>Total</span>
                                <span>₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </div>
</x-app-layout>
