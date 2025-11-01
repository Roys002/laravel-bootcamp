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
    console.log(response);

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
  <div class="space-y-6">
    <h2 class="text-2xl font-bold mb-2 text-gray-800">Daftar Produk</h2>
    <form @submit.prevent="handleSearch" class="flex gap-2 mb-4">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Cari produk..."
        class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-primary"
      />
      <button
        type="submit"
        class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition-colors"
      >
        Cari
      </button>
    </form>
    <div v-if="loading" class="text-center text-gray-500">Loading...</div>
    <div
      v-if="error"
      class="text-red-600 bg-red-50 border border-red-200 rounded-md p-2 mb-2"
    >
      {{ error }}
    </div>
    <div
      v-if="products.length === 0 && !loading"
      class="text-center text-gray-500"
    >
      Tidak ada produk ditemukan.
    </div>
    <div class="grid gap-4">
      <div
        v-for="product in products"
        :key="product.id"
        class="border rounded-lg p-4 shadow-sm bg-white flex flex-col gap-2"
      >
        <div class="flex justify-between items-center">
          <h3 class="text-lg font-semibold text-gray-800">
            {{ product.name }}
          </h3>
          <button
            @click="deleteProduct(product.id)"
            class="text-red-600 hover:text-red-800 px-2 py-1 rounded transition-colors border border-red-100 bg-red-50"
          >
            Hapus
          </button>
        </div>
        <p class="text-gray-600">{{ product.description }}</p>
        <div class="flex gap-4 text-sm">
          <span class="font-medium text-primary"
            >Harga: {{ product.price_formatted }}</span
          >
          <span class="text-gray-500">Stok: {{ product.stock }}</span>
        </div>
      </div>
    </div>
    <div v-if="pagination.last_page > 1" class="flex gap-1 justify-center mt-4">
      <button
        v-for="page in pagination.last_page"
        :key="page"
        @click="fetchProducts(page)"
        :disabled="page === currentPage"
        class="px-3 py-1 rounded border text-sm font-medium transition-colors"
        :class="
          page === currentPage
            ? 'bg-primary text-white border-primary'
            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'
        "
      >
        {{ page }}
      </button>
    </div>
  </div>
</template>