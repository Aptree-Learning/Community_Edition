import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import { address } from 'ip';

export default defineConfig({
    server: {
        https: process.env.APP_ENV == 'production' ? true : false,
        host: address()
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
                'app/Tables/Columns/**',
            ],
        }),
    ],
});
