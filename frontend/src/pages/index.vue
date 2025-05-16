<template>
  <BaseHeader />
  <div id="banner" class="w-full mx-auto pl-4 mb-24 md:min-h-svh grid grid-cols-5 bg-right">
    <div class="grid col-span-1 lg:col-span-2 mx-auto md:px-4 w-auto lg:max-w-[700px]">
      <p class="headerlineOne my-auto max-w-fit h-fit font-extrabold shadow-xl py-2  pr-5 pl-2">
        Tavaszi Mega Akció!
      </p>
      <div class="headerlineTwo max-w-fit" style="font-family:'Tourney',Arial,Helvetica,sans-serif;">
        <ul class="mb-8">
          <li class="font-bold"> Minden táplálékkiegészítő és vitamin</li>
          <li class="font-bold"> Akár 30% kedvezménnyel, és</li>
          <li class="freeshipping w-fit mt-4 rounded-lg font-semibold p-1 text-sky-50 shadow-xl italic">
            Ingyenes kiszállítással!*
          </li>
        </ul>
        <p class="headerlineThree text-base h-fit max-w-fit bg-gray-500/50 p-1 text-amber-50 rounded-md italic"
          style="font-family:'Montserrat',Arial,Helvetica,sans-serif;">
          *<b>Limitált ajánlat:</b> Május 22-31. között!
        </p>
        <button class="checkitout transition-all ease-in-out duration-200 mt-8">
          Megnézem
        </button>
      </div>
    </div>
    <div class="grid col-span-4 lg:col-span-3 m-auto w-1/2 lg:w-full">
      <!-- Ez a másik, jobboldali col. Üresen marad a kép miatt -->
    </div>
  </div>

  <div v-if="productStore.filtered && productStore.filtered.length" class="mx-auto mb-48">
    <p class="text-3xl font-extrabold my-2 underline underline-offset-4 text-center mb-8">Kiemelt akcióink:</p>
    <div class="buttons space-x-8 flex justify-center">
      <button @click="changeToProNutrition" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded">
        Pro Nutrition
      </button>
      <button @click="changeToScitec" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded">
        Scitec
      </button>
      <button @click="changeToBuilder" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded">
        Builder
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
import BaseHeader from '@layout/BaseHeader.vue';
import BaseProductCard from '@layouts/BaseProductCard.vue';
import BaseFooter from '@layout/BaseFooter.vue';
import { useProductStore } from '@stores/ProductStore.mjs';
import { onMounted, ref } from 'vue';

// Store inicializálása
const productStore = useProductStore();
const currentBrand = ref("Builder");

const changeToProNutrition = async () => {
  currentBrand.value = "Pro Nutrition";
  await productStore.sortProductsByBrand(currentBrand.value);
};
const changeToScitec = async () => {
  currentBrand.value = "Scitec";
  await productStore.sortProductsByBrand(currentBrand.value);
};
const changeToBuilder = async () => {
  currentBrand.value = "Builder";
  await productStore.sortProductsByBrand(currentBrand.value);
};

onMounted(async () => {
  try {
    await productStore.getProducts();
    await productStore.sortProductsByBrand(currentBrand.value);
  } catch (error) {
    console.error("Hiba történt:", error);
  }
});
</script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Rasa:ital,wght@0,300..700;1,300..700&family=Tourney:wght@100..900&display=swap');

#banner {
  background-image: linear-gradient(to right, rgba(79, 194, 190, 0.2), rgba(98, 233, 228, 0)), url('../assets/banners/banner.png');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;

  @media screen and (max-width: 1024px) {
    min-height: 75vh;
  }
}


.headerlineOne {
  font-size: clamp(2.2rem, 2.3vw, 3.5rem);
  font-style: italic;
  text-shadow: 3px 3px 8px rgba(79, 66, 1, 0.5);
  color: rgb(94, 47, 97);
  background-color: rgba(255, 255, 255, .9);
  border-radius: 1.5rem;
  border: 3px solid rgb(94, 47, 97);
  margin-bottom: 2rem;
  text-wrap: nowrap;
}

.headerlineTwo {
  font-size: clamp(1rem, 2vw, 2rem);
  font-style: italic;

  @media screen and (max-width: 1024px) {
    min-width: 16rem;
    font-size: 1rem;
    text-wrap: wrap;
  }

}

.freeshipping {
  background-color: rgb(159, 80, 159);
  padding: 0.2rem 0.6rem;


}

.headerlineThree {
  font-size: clamp(0.5rem, 1vw, 1.6rem);
  font-style: italic;
}

.checkitout {
  font-size: clamp(1rem, 2vw, 1.4rem);
  font-style: italic;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
  color: #041e4e;
  background-color: rgb(0, 251, 255);
  border-radius: .5rem;
  border: 3px solid rgba(255, 255, 255, .8);
  padding: 0.5rem 1rem;
}

.checkitout:hover {
  font-size: clamp(1rem, 2vw, 1.4rem);
  font-style: italic;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
  color: rgb(230, 255, 255);
  background-color: #486aa9;
  border-radius: .5rem;
  border: 3px solid rgb(157, 255, 245);
  padding: 0.5rem 1rem;
}

@media screen and (max-width:1536px) {
  .headerlineOne {
    font-size: 2.0rem;
  }
}

@media screen and (min-width:768px) and (max-width: 1024px) {

  .headerlineOne {
    font-size: 1.8rem;
  }
}


@media screen and (min-width:480px) and (max-width: 768px) {
  #banner {
    background-position: calc(100%) right;
    background-image: url('../assets/banners/banner.png');
  }

  .headerlineOne {
    font-size: 1.2rem;
    width: max-content;
    padding: 0.4rem 0.7rem 0.4rem 0.3rem;
    margin-bottom: 1.2rem;
  }

  .headerlineTwo {
    min-width: 5rem;
    max-width: 10rem;
    font-size: 1rem;
    text-wrap: wrap;
    padding-right: 0.2rem;
  }

  .headerlineThree {
    font-size: 0.45rem;
    padding: 0 0.5rem;
  }

  .freeshipping {
    min-width: 10rem;
    font-size: 0.8rem;
    text-wrap: nowrap;
  }

}


@media screen and (max-width: 480px) {
  .headerlineOne {
    min-width: 10rem;
    font-size: 1rem;
    text-wrap: nowrap;
  }

  #banner {
    background-position: calc(100% + 28rem) center;
    background-image: url('../assets/banners/banner.png');
  }
}
</style>
