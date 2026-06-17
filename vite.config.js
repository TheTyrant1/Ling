import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                // Admin
                'resources/admin/scss/app.scss',
                'resources/admin/js/app.js',

                // Personal
                'resources/personal/scss/app.scss',
                'resources/personal/js/app.js',

                // Web
                'resources/web/scss/app.scss',
                'resources/web/js/app.js',

                // Auth (Breeze)
                'resources/auth/css/app.css',
                'resources/auth/scss/app.scss',
                'resources/auth/js/app.js',


            ],
            refresh: true,
        }),
    ],
});
