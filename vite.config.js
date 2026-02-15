import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        https: false,
        hmr: {
            host: 'localhost',
        },
    },
    build: {
        // Asegurar que los assets se generen con URLs relativas o absolutas HTTPS
        assetsDir: 'assets',
    },
});

