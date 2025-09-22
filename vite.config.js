import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // Configurar para acceso externo en desarrollo
    server: {
        host: '0.0.0.0', // Permite acceso desde cualquier IP
        port: 5173,
        strictPort: true,
        origin: 'http://172.20.1.149:5173', // Tu IP local
    },
    // Configurar para producción
    build: {
        outDir: 'public/build',
        assetsDir: 'assets',
        manifest: true,
    },
});
