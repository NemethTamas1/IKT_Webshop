<template>
  <BaseLayout>
    <div v-if="!productStore.loading">
      <div class="flex justify-center w-full lg:w-4/5 mt-16 h-full mx-auto">
        <div class="grid grid-cols-3">
          <div class="grid col-span-1">
            <img :src="productStore.getImagePath(
              productStore.currentProduct?.categories?.[0]?.brand,
              productStore.currentProduct?.quantity,
              productStore.selectedFlavour,
              productStore.currentProduct?.description
            )" :alt="productStore.currentProduct?.description"
              class="mx-auto object-contain w-full h-full" />
          </div>

          <div class="flex pl-6 flex-col justify-center col-span-2 space-y-2 bg-gray-50">
            <p v-if="productStore.currentProduct?.categories?.[0]?.brand != 'Scitec'"
              class="my-2 font-extrabold text-3xl">
              {{ productStore.currentProduct?.categories?.[0]?.brand }}
            </p>
            <p v-else class="my-2 text-xl font-light uppercase">
              Scitec Nutrition
            </p>
            <p class="my-2 font-extrabold text-4xl">
              {{ productStore.currentProduct?.description }}
              <i>({{ productStore.currentProduct?.quantity }} gr)</i>
            </p>
            <p class="my-2 font-semibold text-4xl">
              {{ productStore.currentProduct?.price }} Ft
            </p>
            <p class="my-2 font-semibold italic text-gray-500 text-xl">
              {{
                productStore.currentProduct?.price &&
                  productStore.currentProduct?.quantity
                  ? Math.round(
                    (productStore.currentProduct.price /
                      productStore.currentProduct.quantity) *
                    1000
                  )
                  : ''
              }}
              Ft/kg
            </p>
            <p v-if="productStore.currentProduct?.categories?.[0]?.available === 1"
              class="my-2 font-bold text-green-500">
              Készleten
            </p>
            <p v-else class="my-2 font-bold text-red-500">Elfogyott</p>

            <div class="select-container mt-6">
              <label class="block text-lg font-medium">Ízesítés:</label>
              <select v-model="productStore.selectedFlavour" @change="onFlavourChange" id="scrollable-entity"
                class="mt-1 block max-w-fit py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option v-for="flavour in productStore.availableFlavours" :key="flavour" :value="flavour">
                  {{ flavour }}
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="mx-auto mt-16 w-full border border-lime-500">
        <p class="text-2xl text-left uppercase font-extrabold">Vásárlói értékelések</p>

        <star-rating
        :star-size="24"
        :rating="4.5" 
        :disabled="true"
        :increment="0.5"
        :show-rating="true"
        :max-rating="5"
        :read-only="true"
        :rounded-corners="false" 
        :padding="3" 

        >
      </star-rating>

      </div>
      <div>
        <ProductDetailsInformations 
        :brand="productStore.currentProduct?.categories?.[0]?.brand"
        :description="productStore.currentProduct?.description"  
        />
      </div>
    </div>
    <div v-else class="flex justify-center items-center h-64">
      <div class="text-xl text-gray-500">Betöltés...</div>
    </div>
  </BaseLayout>
</template>

<script setup>
import BaseLayout from '@layouts/BaseLayout.vue';
import StarRating from 'vue-star-rating';
import ProductDetailsInformations from '@layouts/ProductDetailsInformations.vue';

import { onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useProductStore } from '@stores/ProductStore.mjs';

const route = useRoute();
const productStore = useProductStore();

// Route helpers
const getBrandFromRoute = () => route.params.brand;
const getWeightFromRoute = () => Number(route.params.quantity);
const getFlavourFromRoute = () => route.params.flavour;

// Restore state from localStorage on page load (e.g., after F5 refresh)
onMounted(async () => {
  try {
    await productStore.restoreStateFromLocalStorage();

    const brand = getBrandFromRoute();
    const quantity = getWeightFromRoute();
    const flavour = getFlavourFromRoute();

    // Load product details only if needed
    if (
      productStore.currentProduct &&
      (productStore.currentProduct.categories?.[0]?.brand !== brand ||
        productStore.currentProduct.quantity?.toString() !== quantity?.toString() ||
        productStore.currentFlavour !== flavour)
    ) {
      await productStore.loadProductDetails(brand, quantity, flavour);
    } else if (!productStore.currentProduct) {
      await productStore.loadProductDetails(brand, quantity, flavour);
    }

    await productStore.saveStateToLocalStorage();
  } catch (error) {
    console.error('Hiba a komponens adatlekérési részében:', error);
  }
});

// Handle flavor change
const onFlavourChange = () => {
  productStore.updateSelectedFlavour(productStore.selectedFlavour);
  const brand = productStore.currentProduct?.categories?.[0]?.brand;
  const quantity = productStore.currentProduct?.quantity;
  const flavour = productStore.selectedFlavour;

  if (brand && quantity && flavour) {
    productStore.loadProductDetails(brand, quantity, flavour);
  }
  productStore.saveStateToLocalStorage();
  console.log(`Az új íz, amire váltottunk: >> ${productStore.selectedFlavour}`);
};
</script>

<style>
.select-container {
  position: relative;
}

#scrollable-entity {
  max-height: 50px;
  overflow-y: auto;
  width: 100%;
}
</style>
