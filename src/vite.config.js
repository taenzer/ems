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
        port: 5173, // Setzt den Port auf 5173
        origin: "http://localhost:5173", // URL, die der Browser verwenden soll
        hmr: {
            host: "localhost", // Adresse, die der Browser für HMR verwendet
            port: 5173, // Port für HMR (sollte derselbe wie `server.port` sein)
        },
    },
});
