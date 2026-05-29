import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/css/**/*.css',
    ],

    theme: {
        extend: {
            screens: {
                'sm': '640px',
                'md': '768px',
                'lg': '1024px',
                'xl': '1280px',
                '2xl': '1536px',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'brand-dark': '#111827',
                'brand-gray': '#1F2937',
                'brand-text': '#E5E7EB',
                'brand-text-secondary': '#9CA3AF',
                'brand-purple': '#8B5CF6',
                'brand-cyan': '#06B6D4',
            },
            backgroundImage: {
                'brand-gradient': 'linear-gradient(135deg, #8B5CF6 0%, #06B6D4 100%)',
            },
            boxShadow: {
                'brand-glow': '0 0 20px rgba(139, 92, 246, 0.5)',
                'brand-glow-cyan': '0 0 20px rgba(6, 182, 212, 0.5)',
            },
        },
    },

    plugins: [forms],
};
