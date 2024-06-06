import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/scss/app-newp.scss',
                'resources/js/app.js',
                'resources/js/app-newp.js',

                'resources/scss/profile.scss',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~fontawesome': path.resolve(__dirname, 'node_modules/@fortawesome/fontawesome-free'),
            '~toastr': path.resolve(__dirname, 'node_modules/toastr'),
        }
    },
});
