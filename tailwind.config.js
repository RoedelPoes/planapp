import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        'bg-cyan-400',
        'bg-green-400',
        'bg-yellow-400',
        'bg-purple-400',
        'bg-[#4ade80]/100',
        'bg-[#facc15]/100',
        'bg-[#22d3ee]/100',
        'bg-[#c084fc]/100',
      ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
