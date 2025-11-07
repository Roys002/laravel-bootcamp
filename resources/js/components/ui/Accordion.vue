<template>
  <div>
    <button
      @click="open = !open"
      class="w-full flex justify-between items-center px-4 py-2 font-semibold bg-gray-200 text-gray-700 rounded-t focus:outline-none"
    >
      <span>{{ title }}</span>
      <svg
        v-if="open"
        class="w-4 h-4"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M5 15l7-7 7 7"
        />
      </svg>
      <svg
        v-else
        class="w-4 h-4"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M19 9l-7 7-7-7"
        />
      </svg>
    </button>
    <div v-show="open" class="border rounded-b px-4 py-2 bg-white">
      <slot />
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
const props = defineProps({ title: String });
const open = ref(false);
</script>
