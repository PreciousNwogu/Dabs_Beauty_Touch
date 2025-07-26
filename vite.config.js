import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        react({
            include: /\.(jsx|tsx)$/,
        }),
        laravel({
            input: ["resources/css/app.css", "resources/js/App.tsx"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    resolve: {
        extensions: [".js", ".jsx", ".ts", ".tsx"],
    },
});
