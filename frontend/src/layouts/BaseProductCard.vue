<template>
  <div class="grid grid-cols-1 lg:grid-cols-3 mx-8 md:mx-4 lg:m-0 gap-2">
    <div v-for="product in products" :key="product.id"
      class="mx-auto mt-12 px-6 w-full md:w-4/5 rounded-lg bg-gray-100/50 border-b-4 border-r-4 border-sky-700/20 hover:border-sky-700/30 transition-all duration-300 ease-in-out shadow-xl overflow-hidden hover:scale-105 cursor-pointer">

      <!-- Kép és infó: router-linkben -->
      <router-link :to="generateProductUrl(product)" class="block">
        <!-- Kép -->
        <div class="flex justify-center mt-6">
          <img v-if="product.image_path" :src="getProductImage(product.image_path)" :alt="product.description"
            class="max-w-[200px] max-h-[200px]" />
          <div v-else class="w-[200px] h-[200px] flex items-center justify-center bg-gray-200 text-gray-500">
            Nincs kép
          </div>
        </div>

        <!-- Termék adatok -->
        <div class="p-6">
          <p class="text-sm text-gray-600 font-medium mb-2">
            {{ product.brand.name }}
          </p>
          <h2 class="text-gray-900 font-bold text-xl mb-2">
            {{ product.name }}
          </h2>
          <p class="text-sky-500 font-bold text-2xl mb-4">
            {{ productStore.formatToOneThousandPrice(product.price) }} Ft
          </p>
          <p class="text-gray-700 text-base">
            {{ product.productvariants.quantity }} {{ product.productvariants.unit }}.
          </p>
        </div>
      </router-link>

      <!-- Kosár gomb külön, a router-link-en kívül! -->
      <div class="p-6 pt-0 hidden xl:flex">
        <button @click="addVariantToCart(product)"
          class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded w-full">
          Kosárba
        </button>
      </div>

      <router-link :to="generateProductUrl(product)">
        <div class="p-6 pt-0 xl:hidden">
          <button @click="addVariantToCart(product)"
            class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded w-full">
            Megnézem
          </button>
        </div>
      </router-link>
    </div>
  </div>
</template>


<script setup>
import { defineProps, onMounted, computed } from 'vue';
import { useProductStore } from '@/stores/ProductStore.mjs';
import { useCartStore } from '@stores/CartStore.js'
import { ToastService } from '@stores/ToastService.js'

const productStore = useProductStore();
const cartStore = useCartStore();

const props = defineProps({
  products: {
    type: [Array, Object],
    required: true
  }
});

const addVariantToCart = (variant) => {
  const product = {
    id: variant.id,
    name: variant.name,
    price: variant.price,
    image: variant.image_path,
    flavour: variant.flavour,
    quantity: variant.quantity,
    unit: variant.unit,
    brand: variant.brand_name
  }

  cartStore.addToCart(product);
  ToastService.showSuccess("Termék sikeresen hozzáadva a kosárhoz!");
};

// Kép betöltés helper függvény
const getProductImage = (imagePath) => {
  if (!imagePath) return '';
  try {
    const imageUrl = `/src/assets/products_img/${imagePath}`;
    return new URL(imageUrl, import.meta.url).href;
  } catch (error) {
    console.error('Hiba a kép betöltésekor:', error, 'Útvonal:', imagePath);
    return '';
  }
};

// URL generáló függvény
const generateProductUrl = (product) => {
  if (!product || !product.brand || !product.productvariants) return '/';
  const quantity = product.productvariants.quantity;
  const flavour = product.productvariants.flavour;

  return `/${product.name}-${quantity}-${flavour}`;
};

// Meghagyom, hogy egyszerübben lássuk, DE KI KELL VENNI MAJD!
onMounted(() => {
  console.log('Termékek struktúrája:', JSON.stringify(productStore.filtered[0], null, 2));
  console.log("Meghagyom, hogy egyszerübben lássuk, DE KI KELL VENNI MAJD!");
});
</script>
