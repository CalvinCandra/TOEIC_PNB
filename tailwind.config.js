/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                Poppins: ['Poppins', 'sans-serif'],
            },
            colors: {
                // ── Brand Color System (Pure Blue) ─────────────────
                brand: {
                    DEFAULT:      '#0c1f3f', // deep navy   — hero, footer, dark panels
                    card:         '#132952', // navy card   — card bg on dark section
                    light:        '#eff6ff', // blue-50     — light section bg tint
                    muted:        '#bfdbfe', // blue-200    — soft readable text on dark bg
                    accent:       '#2563eb', // blue-600    — CTA buttons, section labels
                    'accent-hover': '#1d4ed8', // blue-700  — hover state
                    soft:         '#dbeafe', // blue-100    — badge bg on light section
                },
            },
        },
    },

    plugins: [
        require('flowbite/plugin'),
    ],
};