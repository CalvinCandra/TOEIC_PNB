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
                // ── Brand Color System ──────────────────────────────
                // Ganti nilai di sini untuk mengubah warna seluruh aplikasi
                brand: {
                    DEFAULT:      '#1e3a8a', // blue-950 — tombol, panel, hero
                    hover:        '#1e40af', // blue-900 — hover tombol
                    light:        '#eff6ff', // blue-50  — bg badge, active sidebar
                    muted:        '#bfdbfe', // blue-200 — teks terang di atas brand
                    accent:       '#f97316', // orange-500 — CTA sekunder (Start Now)
                    'accent-hover': '#ea580c', // orange-600 — hover CTA
                },
            },
        },
    },

    plugins: [
        require('flowbite/plugin'),
    ],
};