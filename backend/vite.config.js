import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        host: "0.0.0.0", // Erlaubt Zugriff von außerhalb des Containers
        port: 5173, // Setzt den Port auf 5173 (oder einen anderen offenen Port)
        origin: "http://localhost:5173", // Setzt die Basis-URL für Assets
    },
});
