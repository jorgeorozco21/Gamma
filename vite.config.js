import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0', // Permite conexiones externas
        cors: true,
        hmr: {
            host: '192.168.1.12', // <-- REEMPLAZA con tu IP local (ej: 192.168.1.64)
        },
        watch: {
            ignored: ['*/storage/framework/views/*'],
        },
    },
});