const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php', 
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: colors.black,
            blue: colors.blue,
            red: colors.red,
            green: colors.green,
            white: colors.white,
            gray: colors.gray,
            orange: colors.orange,
            emerald: colors.emerald,
            indigo: colors.indigo,
            yellow: colors.yellow,
            danger: colors.rose,
            primary: colors.emerald,
            success: colors.green,
            warning: colors.yellow,
            darkgreen: '#2F5662'
        }
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
