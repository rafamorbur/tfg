import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/principal.js",
                "resources/js/cliente.js",
                "resources/js/admin.js",
                "resources/js/reserva.js",
            ],
            refresh: true,
        }),
    ],
});
