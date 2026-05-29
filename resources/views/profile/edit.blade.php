<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-brand-cyan">User Details</p>
                <h1 class="text-2xl font-black text-brand-text">Edit Your Account</h1>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-secondary">Back Home</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[0.85fr_1.15fr]">
            <aside class="rounded-lg border border-slate-700 bg-brand-gray p-6">
                <div class="flex h-20 w-20 items-center justify-center rounded-lg bg-brand-gradient text-3xl font-black text-brand-dark">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="mt-6 text-2xl font-black text-brand-text">{{ $user->name }}</h2>
                <p class="mt-2 break-all text-sm text-brand-text-secondary">{{ $user->email }}</p>

                <div class="mt-8 space-y-3 text-sm text-brand-text-secondary">
                    <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                        <span>Account</span>
                        <span class="font-semibold text-brand-text">Active</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                        <span>Cart Items</span>
                        <span class="font-semibold text-brand-text">{{ count(session('cart', [])) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Member Since</span>
                        <span class="font-semibold text-brand-text">{{ optional($user->created_at)->format('M Y') }}</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-8">
                    @csrf
                    <button type="submit" class="w-full rounded-lg border border-red-400/70 px-5 py-3 font-semibold text-red-200 transition hover:bg-red-500 hover:text-white">
                        Logout
                    </button>
                </form>
            </aside>

            <div class="space-y-6">
                <section class="rounded-lg border border-slate-700 bg-brand-gray p-6 sm:p-8">
                    @include('profile.partials.update-profile-information-form')
                </section>

                <section x-data="cardDetails()" class="rounded-lg border border-slate-700 bg-brand-gray p-6 sm:p-8">
                    <div class="grid gap-8 xl:grid-cols-[0.9fr_1.1fr]">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-[0.2em] text-brand-cyan">Payment Method</p>
                            <h2 class="mt-3 text-xl font-black text-brand-text">Add Card Details</h2>
                            <p class="mt-2 text-sm leading-6 text-brand-text-secondary">Use this card at checkout. For live payments, connect a secure gateway token before storing card data.</p>

                            <div class="mt-6 rounded-lg border border-slate-700 bg-gradient-to-br from-slate-950 via-violet-950 to-cyan-950 p-5 text-white shadow-brand-glow">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-cyan-200">Credit / Debit</p>
                                        <p class="mt-8 font-mono text-xl font-black tracking-[0.18em]" x-text="previewNumber()"></p>
                                    </div>
                                    <span class="rounded-lg bg-white/10 px-3 py-1 text-xs font-black uppercase tracking-[0.14em]" x-text="brand()"></span>
                                </div>
                                <div class="mt-8 flex items-end justify-between gap-4">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-300">Card Holder</p>
                                        <p class="mt-1 text-sm font-black uppercase" x-text="cardName || 'Your Name'"></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-300">Valid Thru</p>
                                        <p class="mt-1 text-sm font-black" x-text="expiry || 'MM/YY'"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form class="space-y-5" @submit.prevent="saved = true">
                            <div>
                                <label for="card_name" class="block text-sm font-semibold text-brand-text">Card Holder Name</label>
                                <input id="card_name" type="text" x-model="cardName" autocomplete="cc-name" class="input-field mt-2" placeholder="Name on card" />
                            </div>

                            <div>
                                <label for="card_number" class="block text-sm font-semibold text-brand-text">Card Number</label>
                                <input id="card_number" type="text" x-model="cardNumber" @input="formatCardNumber()" inputmode="numeric" autocomplete="cc-number" maxlength="19" class="input-field mt-2 font-mono" placeholder="0000 0000 0000 0000" />
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="card_expiry" class="block text-sm font-semibold text-brand-text">Expiry</label>
                                    <input id="card_expiry" type="text" x-model="expiry" @input="formatExpiry()" inputmode="numeric" autocomplete="cc-exp" maxlength="5" class="input-field mt-2 font-mono" placeholder="MM/YY" />
                                </div>
                                <div>
                                    <label for="card_cvv" class="block text-sm font-semibold text-brand-text">CVV</label>
                                    <input id="card_cvv" type="password" x-model="cvv" @input="formatCvv()" inputmode="numeric" autocomplete="cc-csc" maxlength="4" class="input-field mt-2 font-mono" placeholder="123" />
                                </div>
                            </div>

                            <div>
                                <label for="billing_zip" class="block text-sm font-semibold text-brand-text">Billing ZIP / PIN</label>
                                <input id="billing_zip" type="text" x-model="billingZip" autocomplete="postal-code" class="input-field mt-2" placeholder="Billing code" />
                            </div>

                            <div class="flex flex-wrap items-center gap-4">
                                <button type="submit" class="btn-primary">Add Card</button>
                                <p x-show="saved" x-transition class="text-sm font-semibold text-brand-cyan">Card details ready for checkout.</p>
                            </div>
                        </form>
                    </div>
                </section>

                <section class="rounded-lg border border-slate-700 bg-brand-gray p-6 sm:p-8">
                    @include('profile.partials.update-password-form')
                </section>

                <section class="rounded-lg border border-slate-700 bg-brand-gray p-6 sm:p-8">
                    @include('profile.partials.delete-user-form')
                </section>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cardDetails', () => ({
                cardName: '',
                cardNumber: '',
                expiry: '',
                cvv: '',
                billingZip: '',
                saved: false,
                formatCardNumber() {
                    this.saved = false;
                    this.cardNumber = this.cardNumber
                        .replace(/\D/g, '')
                        .slice(0, 16)
                        .replace(/(.{4})/g, '$1 ')
                        .trim();
                },
                formatExpiry() {
                    this.saved = false;
                    const value = this.expiry.replace(/\D/g, '').slice(0, 4);
                    this.expiry = value.length > 2 ? `${value.slice(0, 2)}/${value.slice(2)}` : value;
                },
                formatCvv() {
                    this.saved = false;
                    this.cvv = this.cvv.replace(/\D/g, '').slice(0, 4);
                },
                previewNumber() {
                    const digits = this.cardNumber.replace(/\D/g, '');

                    if (!digits) {
                        return '**** **** **** ****';
                    }

                    return digits
                        .padEnd(16, '*')
                        .replace(/(.{4})/g, '$1 ')
                        .trim();
                },
                brand() {
                    const digits = this.cardNumber.replace(/\D/g, '');

                    if (digits.startsWith('4')) {
                        return 'Visa';
                    }

                    if (/^5[1-5]/.test(digits) || /^2[2-7]/.test(digits)) {
                        return 'Mastercard';
                    }

                    if (/^3[47]/.test(digits)) {
                        return 'Amex';
                    }

                    if (/^6/.test(digits)) {
                        return 'Discover';
                    }

                    return 'Card';
                },
            }));
        });
    </script>
</x-app-layout>
