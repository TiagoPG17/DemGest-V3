import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // Configurar para desarrollo (solo en entorno local)
    server: process.env.APP_ENV === 'local' ? {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        origin: process.env.APP_URL || 'http://localhost:5173',
    } : undefined,
    // Configurar para producción
    build: {
        outDir: 'public/build',
        assetsDir: 'assets',
        manifest: true,
        // Optimizaciones para producción
        cssCodeSplit: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['alpinejs'],
                },
            },
        },
    },
    // Optimización para producción
    optimizeDeps: {
        include: ['alpinejs'],
    },
});

