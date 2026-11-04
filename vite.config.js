import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/style.css',
                'resources/js/app.js',
                'resources/js/runtime.js',
                'resources/js/bootstrap.js',
                'resources/js/vendor-fullcalendar.js',
                'resources/js/vendor-chartjs.js',
                'resources/js/vendors.js',
                'resources/js/2026.js',
                'resources/js/jquery4.js',
                'resources/js/sweetalert2.all.min.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
