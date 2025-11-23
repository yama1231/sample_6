import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',  // ← 127.0.0.1 から 0.0.0.0 に変更
        port: 5173,
        hmr: {
            host: 'localhost',  // ← これを追加
        },
    },
});
