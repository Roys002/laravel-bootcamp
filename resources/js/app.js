import { createApp } from "vue";
import ProductList from "./components/ProductList.vue";

const app = createApp({});
app.component("product-list", ProductList); // Use kebab-case for custom element
app.mount("#app");
