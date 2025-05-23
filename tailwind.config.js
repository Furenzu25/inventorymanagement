/** @type {import('tailwindcss').Config} */
export default {
    content: [
        // You will probably also need these lines
        "./resources/**/**/*.blade.php",
        "./resources/**/**/*.js",
        "./app/View/Components/**/**/*.php",
        "./app/Livewire/**/**/*.php",

        // Add mary
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
    ],
    theme: {
        extend: {
            colors: {
                purple: {
                    100: '#F3E8FF',
                    200: '#E9D5FF',
                    600: '#9333EA',
                    800: '#6B21A8',
                },
                gold: {
                    600: '#D97706',
                    800: '#92400E',
                },
                beige: {
                    100: '#f5f5dc',
                    200: '#e8e4c9',
                    600: '#d6ccab',
                    700: '#c3b091',
                },
            },
            fontFamily: {
                'sans': ['Orbitron', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'],
                'inter': ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
            },
        },
    },

    // Add daisyUI
    plugins: [require("daisyui")]
}
