<template>
  <BaseLayout>
    <div v-if="!isLoading" class="mx-auto">
      <div class="flex justify-center w-full lg:w-4/5 mt-16 h-full mx-auto">
        <div class="grid grid-cols-3 gap-12">
          <!-- Kép szekció -->
          <div class="grid col-span-1">
            <img :src="`/src/assets/products_img/${currentVariant?.image_path}`" :alt="currentVariant?.flavour"
              class="max-w-[350px] max-h-[350px] flex mx-auto items-center justify-center bg-white " />
          </div>

          <!-- Termék details -->
          <div class="flex pl-6 flex-col justify-center col-span-2 space-y-2 bg-gray-50 py-6 rounded-lg shadow-md">
            <!-- Brand full neve -->
            <p class="my-2 text-xl font-light uppercase">
              {{ baseProduct?.brand?.description }}
            </p>
            <!-- Term. név + mennyiség -->
            <p class="my-2 font-extrabold text-4xl">
              {{ baseProduct?.name }}
              <span class="text-gray-600 text-2xl italic">({{ currentVariant?.quantity }} {{ currentVariant?.unit
              }}.)</span>
            </p>

            <!-- Ár -->
            <p class="my-2 font-semibold text-4xl">
              {{ productStore.formatToOneThousandPrice(currentVariant?.price) }} Ft
            </p>

            <!-- Kg ár -->
            <p v-if="currentVariant?.price && currentVariant?.quantity"
              class="my-2 font-semibold italic text-gray-500 text-xl">
              {{ productStore.formatToOneThousandPrice(calculatePricePerKg) }} Ft/kg
            </p>

            <!-- Készlet státusza -->
            <p v-if="currentVariant?.available === 1" class="my-2 font-bold text-green-500">
              Készleten
            </p>
            <p v-else class="my-2 font-bold text-red-500">
              Elfogyott
            </p>

            <!-- Kiszerelés options -->
            <div class="select-container" v-if="availableSizes.length">
              <label class="block text-lg font-medium">Kiszerelés:</label>
              <select v-model="selectedSize" @change="handleSizeChange"
                class="my-2 block min-w-fit py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                <option v-for="size in availableSizes" :key="size" :value="size">
                  {{ size }} {{ currentVariant?.unit }}
                </option>
              </select>
            </div>

            <!-- Ízesítés options -->
            <div class="select-container mt-6" v-if="availableFlavours.length">
              <label class="block text-lg font-medium">Ízesítés:</label>
              <select v-model="selectedFlavour" @change="handleFlavourChange"
                class="mt-1 block max-w-fit py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                <option v-for="flavour in availableFlavours" :key="flavour" :value="flavour">
                  {{ flavour }}
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div>
        <ProductDetailsInformations :brand="baseProduct?.brand?.name" :description="baseProduct?.product_line" />
      </div>
    </div>

    <!-- Betöltő képernyő -->
    <div v-else class="flex justify-center items-center h-64">
      <div class="text-xl text-gray-500">Betöltés...</div>
    </div>
  </BaseLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useProductStore } from '@stores/ProductStore';
import BaseLayout from '@layouts/BaseLayout.vue';
import ProductDetailsInformations from '@layouts/ProductDetailsInformations.vue';


const route = useRoute();
const router = useRouter();
const productStore = useProductStore();

const isLoading = ref(true);
const baseProduct = ref(null);
const currentVariant = ref(null);
const selectedFlavour = ref('');
const selectedSize = ref('');

const availableSizes = computed(() => {
  if (!baseProduct.value?.productvariants) return [];

  // Csak az egyedi méreteket gyűjtjük ki
  const sizes = new Set(baseProduct.value.productvariants.map(v => v.quantity));
  return Array.from(sizes).sort((a, b) => a - b); // Rendezzük növekvő sorrendbe
});

const availableFlavours = computed(() => {
  if (!baseProduct.value?.productvariants || !selectedSize.value) return [];

  // Az aktuális mérethez tartozó ízeket gyűjtjük ki
  return baseProduct.value.productvariants
    .filter(v => v.quantity === Number(selectedSize.value))
    .map(v => v.flavour);
});

const calculatePricePerKg = computed(() => {
  if (!currentVariant.value?.price || !currentVariant.value?.quantity) return 0;
  return Math.round((currentVariant.value.price / currentVariant.value.quantity) * 1000);
});

const handleSizeChange = async () => {
  if (!baseProduct.value || !selectedSize.value) return;
  
  const variant = baseProduct.value.productvariants.find(
    v => v.quantity === Number(selectedSize.value)
  );
  
  if (!variant) return;
  
  selectedFlavour.value = variant.flavour;
  const newUrl = `/${baseProduct.value.brand.name}-${variant.quantity}${variant.unit}-${variant.flavour}`;
  
  await router.push(newUrl);
  await loadProduct(baseProduct.value.brand.name, variant.quantity, variant.flavour);
};

const handleFlavourChange = async () => {
  if (!baseProduct.value || !selectedFlavour.value || !selectedSize.value) return;
  
  const variant = baseProduct.value.productvariants.find(
    v => v.quantity === Number(selectedSize.value) && 
        v.flavour === selectedFlavour.value
  );
  
  if (!variant) return;
  
  const newUrl = `/${baseProduct.value.brand.name}-${variant.quantity}${variant.unit}-${variant.flavour}`;
  await router.push(newUrl);
  await loadProduct(baseProduct.value.brand.name, variant.quantity, variant.flavour);
};

const loadProduct = async (searchName, quantity, flavour) => {
  try {
    isLoading.value = true;

    if (productStore.products.length === 0) {
      await productStore.getProducts();
    }
    const brandProducts = productStore.products.filter(p => p.brand?.name === searchName);
    const product = brandProducts.find(p => {
      if (!Array.isArray(p.productvariants)) return false;
      
      return p.productvariants.some(v => {
        const variantQuantity = String(v.quantity);
        const searchQuantity = String(quantity).replace(/gr|tab/gi, '').trim();
        return variantQuantity === searchQuantity;
      });
    });

    if (!product) {
      console.error('Nem található termék:', { searchName, quantity });
      isLoading.value = false;
      return;
    }
    // Variáns megkeresése
    const variant = product.productvariants.find(v => {
      const variantQuantity = String(v.quantity);
      const searchQuantity = String(quantity).replace(/gr|tab/gi, '').trim();
      const variantFlavour = v.flavour?.toLowerCase();
      const searchFlavour = flavour?.toLowerCase();
      
      return variantQuantity === searchQuantity && 
             variantFlavour === searchFlavour;
    });

    if (!variant) {
      // Ha nincs pontos találat >> mennyiséghez tartozó első variánst
      const fallbackVariant = product.productvariants.find(v => 
        String(v.quantity) === String(quantity).replace(/gr|tab/gi, '').trim()
      );
      
      if (fallbackVariant) {
        const newUrl = `/${product.brand.name}-${fallbackVariant.quantity}${fallbackVariant.unit}-${fallbackVariant.flavour}`;
        await router.replace(newUrl);
        
        baseProduct.value = product;
        currentVariant.value = fallbackVariant;
        selectedFlavour.value = fallbackVariant.flavour;
        selectedSize.value = fallbackVariant.quantity;
        return;
      }
      
      console.error('Nem található variáns:', { quantity, flavour });
      isLoading.value = false;
      return;
    }

    baseProduct.value = product;
    currentVariant.value = variant;
    selectedFlavour.value = variant.flavour;
    selectedSize.value = variant.quantity;
    
  } catch (error) {
    console.error('Hiba a termék betöltése során:', error);
  } finally {
    isLoading.value = false;
  }
};

onMounted(async () => {
  const searchName = route.params.brand;
  const quantity = route.params.quantity;
  const flavour = route.params.flavour;

  await loadProduct(searchName, quantity, flavour);
});

// Route változás figyelése
watch(
  () => route.params,
  async (newParams) => {
    const searchName = newParams.brand;
    const quantity = newParams.quantity;
    const flavour = newParams.flavour;

    await loadProduct(searchName, quantity, flavour);
  }
);
</script>
