import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/routines.js', 
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build', // Asegúrate de que los archivos se generen en esta ruta
    },
});
