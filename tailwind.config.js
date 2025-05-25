const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    safelist: [
        'bg-gray-100',
        'text-gray-800',
        'bg-gray-500',
        'bg-sky-100',
        'text-sky-800',
        'bg-sky-500',
        'bg-emerald-100',
        'text-emerald-800',
        'bg-emerald-500',
        'bg-orange-100',
        'text-orange-800',
        'bg-orange-500',
        'bg-rose-100',
        'text-rose-800',
        'bg-rose-500',
    ],

    theme: {
        extend: {
            fontFamily: {
                // sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                sans: ["K2D", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require('@tailwindcss/aspect-ratio'),
    ],
};
