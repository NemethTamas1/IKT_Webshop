<template>
  <div class="grid grid-cols-1 lg:grid-cols-3 mx-8 md:mx-4 lg:m-0 gap-2">
    <div v-for="product in products" :key="product.id"
      class="mx-auto mt-12 px-6 w-full md:w-4/5 rounded-lg bg-gray-100/50 border-b-4 border-r-4 border-sky-700/20 hover:border-sky-700/30 transition-all duration-300 ease-in-out shadow-xl overflow-hidden hover:scale-105 cursor-pointer">
      <router-link :to="generateProductUrl(product)">
        <div class="h-full overflow-hidden flex items-center justify-center my-auto">
          <!-- Kép -->
          <div class="flex justify-center">
            <img v-if="product.image_path" :src="getProductImage(product.image_path)" :alt="product.description"
              class="max-w-[200px] max-h-[200px]" />
            <div v-else class="w-[200px] h-[200px] flex items-center justify-center bg-gray-200 text-gray-500">
              Nincs kép
            </div>
          </div>

          <!-- Termék details -->
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
            <div class="mt-6">
              <button class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded">
                Kosárba
              </button>
            </div>
          </div>
        </div>
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted, computed } from 'vue';
import { useProductStore } from '@/stores/ProductStore.mjs';

const productStore = useProductStore();

const props = defineProps({
  products: {
    type: [Array, Object],
    required: true
  }
});

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
  // Ha nincs termék vagy hiányoznak az adatok, visszatérünk a főoldalra
  if (!product || !product.brand || !product.productvariants) return '/';

  // A termék nevét vagy a brand nevét használjuk az URL-ben
  const urlName = product.name === 'Jumbo!' ? 'Jumbo!' : product.brand.name;

  // Első variáns adatainak használata
  const quantity = product.productvariants.quantity;
  const flavour = product.productvariants.flavour;

  return `/${urlName}-${quantity}-${flavour}`;
};

// Meghagyom, hogy egyszerübben lássuk, DE KI KELL VENNI MAJD!
onMounted(() => {
  console.log('Termékek struktúrája:', JSON.stringify(productStore.filtered[0], null, 2));
  console.log("Meghagyom, hogy egyszerübben lássuk, DE KI KELL VENNI MAJD!");
});
</script>
