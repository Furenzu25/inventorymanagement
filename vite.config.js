import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // Ensure manifest is generated
        manifest: true,
        // Optimize build
        minify: 'terser',
        // Make output more verbose to diagnose issues
        outDir: 'public/build',
    },
});
