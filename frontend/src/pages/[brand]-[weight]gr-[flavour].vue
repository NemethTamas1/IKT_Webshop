<template>
  <BaseLayout>
    <div v-if="!loading">

      <div class="flex justify-center w-full h-full mx-auto">

        <div class="grid grid-cols-3">
          <div class="grid col-span-1">
            <img :src="getImagePath(
              product.categories[0].brand,
              product.weight,
              product.flavour,
              product.description
            )" :alt="product.description" class="mx-auto object-contain w-full h-full bg-lime-300" />
          </div>
          <!-- Kép bal oldalon -->



          <!-- Információk a jobb oldalon -->
          <div class="flex pl-6 flex-col justify-center col-span-2 space-y-2 bg-gray-50">
            <p class="my-2 font-extrabold text-3xl">
              {{ product.categories[0]?.brand }}
            </p>
            <p class="my-2 font-extrabold text-4xl">
              {{ product.description }} <i>({{ product.weight }}gr)</i>
            </p>
            <p class="my-2 font-semibold text-4xl">
              {{ product.price }} Ft
            </p>
            <p class="my-2 font-semibold italic text-gray-500 text-xl">
              {{ Math.round(product.price / product.weight * 1000) }} Ft / kg
            </p>
            <p v-if="product.categories[0]?.available === 1" class="text-3xl text-green-500 font-bold">
              Raktáron
            </p>
            <p v-else class="text-3xl text-red-600 font-semibold">
              Nincs raktáron
            </p>
            <!-- <FormKit type="select" label="Íz kiválasztása" name="flavour"
              class="w-full p-3 rounded-md bg-gray-600 text-slate-700"
              @click="getFlavours(product.description, product.weight)" :options="filteredFlavours" /> -->

            <!-- <p v-for="egy in filteredFlavours" :key="egy.id">
              {{ egy.value }}
            </p> -->
            <label>ÍZ kiválasztása</label>
            <select @click="getFlavours(product.description, product.weight)" class="w-fit min-w-[250px] bg-gray-400 text-lime-300 text-center text-lg font-bold py-2 rounded" name="flavours" label="Íz kiválasztása">
              <option class="text-sky-500 bg-sky-50 font-semibold px-4" v-for="egy in filteredFlavours" :key="egy.id" value={{egy.value}}>{{ egy.label }}</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div v-else>

    </div>
  </BaseLayout>
</template>

<script setup>
//Importok
import BaseLayout from '@layouts/BaseLayout.vue';
import { useProductStore } from '@stores/ProductStore';
import { onMounted, computed, ref } from 'vue';
import { useRoute } from 'vue-router';
import { ToastService } from '@stores/ToastService.js';

//Változók
const productStore = useProductStore();
const route = useRoute();
const product = computed(() => productStore.oneProduct[0] ?? null);
const loading = ref(true);
const images = import.meta.glob('@/assets/products_img/**/*.webp', { eager: true })
const error = ref(null);
const filteredFlavours = ref([]);
const description = route.params.description;
const weight = Number(route.params.weight);
const brand = route.params.brand;
const flavour = route.params.flavour;
//Függvények
const getImagePath = (brand, weight, flavour, description) => {
  const getProductLine = (brand, description) => {
    if (brand === 'Scitec') {
      return description.includes('Jumbo') ? 'Jumbo!' : 'wpp';
    }

    const brandLines = {
      'Pro Nutrition': 'Pro Whey',
      'Builder': 'WheyProtein'
    };

    return brandLines[brand] || '';
  }
  const subfolder = getProductLine(brand, description)
  const expectedPattern = `products_img/${brand}/${subfolder}/${weight}/${weight}_${flavour}.webp`
  const key = Object.keys(images).find(path =>
    path.toLowerCase().includes(expectedPattern.toLowerCase())
  );

  return key ? images[key].default : ''
}

onMounted(async () => {
  loading.value = true;
  error.value = null;
  const toastId = ToastService.showLoading("Termékadatok betöltése folyamatban...");
  try {
    await productStore.getProducts();
    await productStore.sortGetOneProduct(brand, weight, flavour);

    if (description && weight) {
      await getFlavours(description, weight);
    }
    ToastService.updateToSuccess(toastId, "Termékadatok sikeresen betöltve!");
  } catch (err) {
    error.value = err.message;
    ToastService.updateToError(
      toastId,
      `Hiba az adatok betöltésekor: ${error.message}`
    );
  } finally {
    loading.value = false;
  }
})
const getFlavours = async (description, weight) => {
  try {
    const flavours = await productStore.sortProductByDescriptionAndWeigthToGetFlavours(description, weight);
    // Formátum FormKit számára
    filteredFlavours.value = flavours.map((flavour) => ({
      label: flavour, // Felhasználónak megjelenő label
      value: flavour, // Kiválasztott érték
    }));
    console.log("Flavours betöltve:", filteredFlavours.value); // Debug
  } catch (error) {
    console.error("Hiba az ízek betöltésekor:", error);
  }
};
</script>