import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // Ensure manifest is generated in the correct location
            publicDirectory: 'public',
            buildDirectory: 'build',
        }),
    ],
    build: {
        // Ensure manifest is generated
        manifest: true,
        // Optimize build
        minify: 'terser',
        // Make sure output goes to the right place
        outDir: 'public/build',
    },
});
