import {defineConfig} from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import {wayfinder} from "@laravel/vite-plugin-wayfinder";
import path from 'path';

export default defineConfig({
    plugins: [
        wayfinder(),
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/main.jsx",
                "resources/css/filament/store/theme.css",
            ],
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        extensions: ['.js', '.jsx', '.ts', '.tsx'],
        alias: {
            '@routes': path.resolve(__dirname, './resources/js/routes'),
            '@actions': path.resolve(__dirname, './resources/js/actions'),
        },
    },
});
