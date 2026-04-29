import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', ...defaultTheme.fontFamily.sans],
                inter: ['Inter', 'ui-sans-serif', 'system-ui'],
            },
            colors: {
                'bali-cream': '#F5EFE6',
                'bali-wood': '#8B5E3C',
                'bali-leaf': '#3A7D44',
                'bali-orange': '#F97316',
                'bali-sand': '#F8F4E6',
                'bali-palm': '#2D5016',
                // Dark luxury palette
                'dark-bg': '#0f1117',
                'dark-card': '#1a1d27',
                'dark-nav': '#13161f',
            },
        },
    },

    plugins: [forms],
};
