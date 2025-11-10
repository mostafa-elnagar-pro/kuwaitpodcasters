import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    publicDir: 'public',
    server: {
        hmr: {
            host: "0.0.0.0",
        },
        port: 3000,
        host: true,
    },
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/scss/media.scss",
                "resources/scss/style.scss",
            ],
            refresh: true,
        }),
    ]
});
