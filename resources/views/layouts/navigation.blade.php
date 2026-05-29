<nav x-data="{ open: false }" class="bg-brand-dark shadow-[0_10px_40px_rgba(15,23,42,0.35)] border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-6">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <x-application-logo class="block h-9 w-auto fill-current text-brand-text" />
                    <span class="font-semibold text-brand-text text-lg">{{ config('app.name', 'Ecommerce') }}</span>
                </a>

                <div class="hidden sm:flex sm:items-center sm:space-x-4">
                    <x-nav-link :href="url('/')" :active="request()->is('/')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/products')" :active="request()->is('products*')">
                        {{ __('Products') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/cart')" :active="request()->is('cart')">
                        {{ __('Cart') }}
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('wishlist.index')" :active="request()->is('wishlist')">
                            {{ __('Wishlist') }}
                        </x-nav-link>
                        <x-nav-link :href="route('orders.index')" :active="request()->is('orders')">
                            {{ __('Orders') }}
                        </x-nav-link>
                        <x-nav-link :href="route('profile.edit')" :active="request()->is('profile') || request()->is('user')">
                            {{ __('User') }}
                        </x-nav-link>
                        @if(auth()->user()->is_admin)
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->is('admin*')">
                                {{ __('Admin') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg px-5 py-2 text-sm font-semibold text-brand-text bg-brand-purple border border-brand-purple hover:bg-opacity-80 transition duration-200 shadow-brand-glow hover:shadow-lg">
                        {{ __('Sign in') }}
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg px-5 py-2 text-sm font-semibold text-brand-dark bg-brand-cyan hover:bg-opacity-90 transition duration-200 shadow-brand-glow-cyan hover:shadow-lg">
                            {{ __('Register') }}
                        </a>
                    @endif
                @endguest

                @auth
                    <a href="{{ route('profile.edit') }}" class="btn-secondary">
                        {{ __('Edit User') }}
                    </a>
                @endauth
                <a href="{{ url('/products') }}" class="btn-primary">
                    {{ __('Shop Now') }}
                </a>
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-full text-brand-text hover:bg-brand-gray focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-brand-dark border-t border-slate-800">
        <div class="px-4 py-3 space-y-1">
            <x-responsive-nav-link :href="url('/')" :active="request()->is('/')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/products')" :active="request()->is('products*')">
                {{ __('Products') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/cart')" :active="request()->is('cart')">
                {{ __('Cart') }}
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('wishlist.index')" :active="request()->is('wishlist')">
                    {{ __('Wishlist') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->is('orders')">
                    {{ __('Orders') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->is('profile') || request()->is('user')">
                    {{ __('User') }}
                </x-responsive-nav-link>
                @if(auth()->user()->is_admin)
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->is('admin*')">
                        {{ __('Admin') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>
        @guest
            <div class="px-4 py-4 border-t border-slate-800 space-y-2">
                <a href="{{ route('login') }}" class="block rounded-lg px-4 py-3 text-center text-sm font-semibold text-brand-text bg-brand-purple hover:bg-opacity-80 transition duration-200 shadow-brand-glow">
                    {{ __('Sign in') }}
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block rounded-lg px-4 py-3 text-center text-sm font-semibold text-brand-dark bg-brand-cyan hover:bg-opacity-90 transition duration-200 shadow-brand-glow-cyan">
                        {{ __('Register') }}
                    </a>
                @endif
            </div>
        @endguest
    </div>
</nav>
