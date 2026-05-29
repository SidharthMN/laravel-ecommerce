@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-white text-start text-base font-semibold text-white bg-white/10 drop-shadow-[0_0_10px_rgba(255,255,255,0.85)] focus:outline-none focus:text-white focus:bg-white/10 focus:border-brand-cyan transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-brand-text-secondary hover:text-white hover:bg-white/5 hover:border-brand-cyan hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.65)] focus:outline-none focus:text-white focus:bg-white/5 focus:border-brand-cyan transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
