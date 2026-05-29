@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-white text-sm font-semibold leading-5 text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.85)] focus:outline-none focus:border-brand-cyan transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-brand-text-secondary hover:text-white hover:border-brand-cyan hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.65)] focus:outline-none focus:text-white focus:border-brand-cyan transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
