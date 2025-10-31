<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const products = ref([]);
const loading = ref(false);
const error = ref(null);
const pagination = ref({});
const searchQuery = ref("");
const currentPage = ref(1);

const fetchProducts = async (page = 1) => {
  loading.value = true;
  error.value = null;
  currentPage.value = page;
  try {
    const response = await axios.get("/api/v1/products", {
      params: {
        page,
        per_page: 15,
        search: searchQuery.value,
      },
    });
    products.value = response.data.data;
    pagination.value = response.data.meta;
  } catch (err) {
    error.value = err.response?.data?.message || "Terjadi kesalahan";
  } finally {
    loading.value = false;
  }
};

const createProduct = async (productData) => {
  try {
    const response = await axios.post("/api/v1/products", productData);
    products.value.unshift(response.data.data);
    return response.data;
  } catch (err) {
    if (err.response?.status === 422) {
      const errors = err.response.data.errors;
      throw new Error(Object.values(errors).flat().join(", "));
    }
    throw err;
  }
};

const deleteProduct = async (id) => {
  if (!confirm("Yakin hapus produk ini?")) return;
  try {
    await axios.delete(`/api/v1/products/${id}`);
    products.value = products.value.filter((p) => p.id !== id);
  } catch (err) {
    error.value = "Gagal menghapus produk";
  }
};

const handleSearch = () => {
  fetchProducts(1);
};

onMounted(() => {
  fetchProducts();
});
</script>

<template>
  <div class="product-list">
    <h2>Daftar Produk</h2>
    <form @submit.prevent="handleSearch" style="margin-bottom: 1rem">
      <input v-model="searchQuery" type="text" placeholder="Cari produk..." />
      <button type="submit">Cari</button>
    </form>
    <div v-if="loading">Loading...</div>
    <div v-if="error" class="error">{{ error }}</div>
    <div v-for="product in products" :key="product.id" class="product-card">
      <h3>{{ product.name }}</h3>
      <p>{{ product.description }}</p>
      <p>Harga: {{ product.price_formatted }}</p>
      <p>Stok: {{ product.stock }}</p>
      <button @click="deleteProduct(product.id)">Hapus</button>
    </div>
    <div class="pagination">
      <button
        v-for="page in pagination.last_page"
        :key="page"
        @click="fetchProducts(page)"
        :disabled="page === currentPage"
        :style="page === currentPage ? 'font-weight:bold;background:#eee;' : ''"
      >
        {{ page }}
      </button>
    </div>
  </div>
</template>