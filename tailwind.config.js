import { defineConfig } from "tailwindcss";

export default defineConfig({
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/shadcn-vue/dist/**/*.js",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
});
