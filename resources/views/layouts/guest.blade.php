<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-brand-dark text-brand-text">
        <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 bg-brand-dark">
            <div class="w-full max-w-md">
                <div class="mb-6 text-center">
                    <a href="/">
                        <x-application-logo class="w-16 h-16 fill-current text-brand-text mx-auto" />
                    </a>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-brand-gray shadow-[0_30px_80px_rgba(15,23,42,0.35)]">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
