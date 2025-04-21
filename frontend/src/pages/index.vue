<template>
  <BaseHeader />
  <div id="banner" class="min-w-[1080px] min-h-svh grid grid-cols-2 mx-auto mb-24">

    <div class="grid m-auto lg:max-w-[700px] h-3/5 w-4/5">
      <div class="headerlineOne h-fit shadow-xl" style="font-family:'Tourney',Arial,Helvetica,sans-serif;">
        <p>Tavaszi Mega Akció!</p>
      </div>
      <div class="headerlineTwo h-fit" style="font-family:'Tourney',Arial,Helvetica,sans-serif;">
        <ul>
          <li class="font-bold"> Minden táplálékkiegészítő és vitamin</li>
          <li class="font-bold"> Akár 30% kedvezménnyel, és</li>
          <li class="bg-purple-400 w-fit px-3 mt-1 rounded-lg text-sky-50 shadow-xl italic">
            Ingyenes kiszállítással!*</li>
        </ul>
      </div>

      <p class="text-base h-fit w-fit bg-gray-500/50 p-1 text-amber-50 rounded-md italic"
        style="font-family:'Montserrat'Arial,Helvetica,sans-serif;">
        *<b>Limitált ajánlat:</b> Május 22-31. között!
      </p>
      <button class="checkitout transition-all ease-in-out duration-200">
        Megnézem
      </button>
    </div>

    <div class="grid">
      <!-- Ez a másik, jobboldali col. Üresen marad a kép miatt -->
    </div>

  </div>
  <div v-if="productStore.filtered && productStore.filtered.length" class="mx-auto mb-48">
    <p class="text-3xl font-extrabold my-2 underline underline-offset-4 text-center mb-8">Kiemelt akcióink:</p>
    <div class="buttons space-x-8 flex justify-center">
      <button @click="changeToBuilder" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded ">
        Builder
      </button>

      <button @click="changeToScitec" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded">
        Scitec
      </button>

      <button @click="changeToProNutrition" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded">
        Pro Nutrition
      </button>

    </div>
    <BaseProductCard :products="productStore.filtered" />
  </div>
  <div v-else class="">
    <p>Betöltés folyamatban vagy nincs találat...</p>
  </div>
  <BaseFooter />
</template>

<script setup>
import BaseHeader from '@layout/BaseHeader.vue'
import BaseFooter from '@layout/BaseFooter.vue'
import BaseProductCard from '@layouts/BaseProductCard.vue';

import { useProductStore } from '@stores/ProductStore.mjs';
import { storeToRefs } from 'pinia';
import { onMounted, ref } from 'vue';

const productStore = useProductStore();
const { products } = storeToRefs(productStore);
const filteredByBrand = ref("Builder");

const changeToProNutrition = (async () => {
  filteredByBrand.value = "Pro Nutrition";
  await productStore.sortProductsByBrand(filteredByBrand.value);
});
const changeToScitec = (async () => {
  filteredByBrand.value = "Scitec";
  await productStore.sortProductsByBrand(filteredByBrand.value);
});
const changeToBuilder = (async () => {
  filteredByBrand.value = "Builder";
  productStore.sortProductsByBrand(filteredByBrand.value);
});
onMounted(async () => {
  try {
    await productStore.getProducts();
    await productStore.sortProductsByBrand(filteredByBrand.value);
    console.log("Termékek betöltve:", productStore.filtered);
  } catch (error) {
    console.error("Hiba történt:", error);
  }
});



</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Rasa:ital,wght@0,300..700;1,300..700&family=Tourney:wght@100..900&display=swap');

#banner {
  background-image: linear-gradient(to right, rgba(79, 194, 190, 0.2), rgba(98, 233, 228, 0)), url('../assets/banners/banner.png');
  /* A gradient ad bele egy kis színes átmenetet, hogy ne legyen annyira "matt" */
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}

.headerlineOne {
  font-size: 3.5rem;
  font-weight: 800;
  font-style: italic;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
  color: #041e4e;
  background-color: rgb(0, 251, 255);
  border-radius: 1.5rem;
  border: 3px solid rgba(255, 255, 0, 0.7);
  width: fit-content;
  padding-left: 1rem;
  padding-right: 1.5rem;
  margin-bottom: 1rem;
}

.headerlineTwo {
  font-size: 2rem;
  font-style: italic;
}

.checkitout {
  font-size: 1.4rem;
  font-weight: 800;
  font-style: italic;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
  color: #041e4e;
  background-color: rgb(0, 251, 255);
  border-radius: .5rem;
  border: 3px solid rgba(255, 255, 255, .8);
  width: fit-content;
  height: fit-content;
  padding: 0.5rem 1rem;
}

.checkitout:hover {
  font-size: 1.4rem;
  font-weight: 800;
  font-style: italic;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
  color: rgb(230, 255, 255);
  background-color: #486aa9;
  border-radius: .5rem;
  border: 3px solid rgb(157, 255, 245);
  width: fit-content;
  height: fit-content;
  padding: 0.5rem 1rem;
}
</style>
