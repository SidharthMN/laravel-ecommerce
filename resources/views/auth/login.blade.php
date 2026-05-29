<x-guest-layout>
    <div class="mb-6 text-center">
        <p class="text-sm uppercase tracking-[0.35em] text-brand-cyan/80">Streetwear & Performance</p>
        <h1 class="mt-3 text-3xl sm:text-4xl font-black tracking-tight text-brand-text">E-Commerce</h1>
    </div>

    <div x-data="{ tab: 'login' }" class="rounded-xl border border-slate-700 bg-brand-dark overflow-hidden">
        <div class="border-b border-slate-700 bg-brand-dark px-4 py-3">
            <ul class="flex gap-2" role="tablist">
                <li class="flex-1">
                    <button type="button" @click="tab = 'login'" :class="tab === 'login' ? 'border-b-4 border-brand-purple text-brand-text' : 'text-brand-text-secondary hover:text-brand-text'" class="w-full px-4 py-3 text-sm font-semibold transition">
                        Sign in
                    </button>
                </li>
                <li class="flex-1">
                    <button type="button" @click="tab = 'register'" :class="tab === 'register' ? 'border-b-4 border-brand-cyan text-brand-text' : 'text-brand-text-secondary hover:text-brand-text'" class="w-full px-4 py-3 text-sm font-semibold transition">
                        Register
                    </button>
                </li>
            </ul>
        </div>

        <div class="px-6 sm:px-8 py-8">
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <div x-show="tab === 'login'" x-cloak>
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-brand-text text-sm font-semibold" />
                        <x-text-input id="email" class="mt-2 block w-full bg-brand-dark border-slate-700 text-brand-text text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-400" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-brand-text text-sm font-semibold" />
                        <x-text-input id="password" class="mt-2 block w-full bg-brand-dark border-slate-700 text-brand-text text-sm" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-400" />
                    </div>

                    <div class="flex items-center justify-between text-xs text-brand-text-secondary">
                        <label class="inline-flex items-center gap-2">
                            <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-700 bg-brand-dark text-brand-cyan focus:ring-brand-cyan" />
                            Remember me
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-brand-cyan hover:text-brand-cyan/80" href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-primary w-full mt-6">
                        {{ __('Log in') }}
                    </button>
                </form>
            </div>

            <div x-show="tab === 'register'" x-cloak>
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="register_name" :value="__('Name')" class="text-brand-text text-sm font-semibold" />
                        <x-text-input id="register_name" class="mt-2 block w-full bg-brand-dark border-slate-700 text-brand-text text-sm" type="text" name="name" :value="old('name')" required autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-rose-400" />
                    </div>

                    <div>
                        <x-input-label for="register_email" :value="__('Email')" class="text-brand-text text-sm font-semibold" />
                        <x-text-input id="register_email" class="mt-2 block w-full bg-brand-dark border-slate-700 text-brand-text text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-400" />
                    </div>

                    <div>
                        <x-input-label for="register_password" :value="__('Password')" class="text-brand-text text-sm font-semibold" />
                        <x-text-input id="register_password" class="mt-2 block w-full bg-brand-dark border-slate-700 text-brand-text text-sm" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-400" />
                    </div>

                    <div>
                        <x-input-label for="register_password_confirmation" :value="__('Confirm Password')" class="text-brand-text text-sm font-semibold" />
                        <x-text-input id="register_password_confirmation" class="mt-2 block w-full bg-brand-dark border-slate-700 text-brand-text text-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-rose-400" />
                    </div>

                    <button type="submit" class="btn-primary w-full mt-6">
                        {{ __('Register') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
