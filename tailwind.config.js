import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './app/**/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            screens: {
                'xs': '475px',
                'sm': '640px',
                'md': '768px',
                'lg': '1024px',
                'xl': '1280px',
                '2xl': '1536px',
            },
        },
    },

    plugins: [forms],
    // Optimización para producción
    important: false,
    future: {
        hoverOnlyWhenSupported: true,
    },
};
