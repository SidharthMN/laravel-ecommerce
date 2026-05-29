<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-brand-text">Create Account</h1>
        <p class="mt-2 text-sm text-brand-text-secondary">Join our streetwear community</p>
    </div>

    <div class="rounded-xl border border-slate-700 bg-brand-dark p-6 sm:p-8">
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Name')" class="text-brand-text text-sm font-semibold" />
                <x-text-input id="name" class="mt-2 block w-full bg-brand-dark border-slate-700 text-brand-text text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-rose-400" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" class="text-brand-text text-sm font-semibold" />
                <x-text-input id="email" class="mt-2 block w-full bg-brand-dark border-slate-700 text-brand-text text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-400" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" class="text-brand-text text-sm font-semibold" />
                <x-text-input id="password" class="mt-2 block w-full bg-brand-dark border-slate-700 text-brand-text text-sm" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-400" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-brand-text text-sm font-semibold" />
                <x-text-input id="password_confirmation" class="mt-2 block w-full bg-brand-dark border-slate-700 text-brand-text text-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-rose-400" />
            </div>

            <div class="flex items-center justify-between pt-4">
                <a class="text-sm text-brand-cyan hover:text-brand-cyan/80" href="{{ route('login') }}">
                    {{ __('Already have an account?') }}
                </a>

                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
