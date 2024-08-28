// tailwind.config.js
module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#1D4ED8',
                secondary: '#9333EA',
                background: '#020617',
                card: '#0F172A',
            },
        },
    },
    plugins: [],
};
