<template>
  <BaseHeader />
  <div id="banner" class="w-full mx-auto pl-4 mb-24 md:min-h-svh grid grid-cols-5 bg-right 
  ">
    <div class="grid col-span-2 mx-auto md:px-4 w-auto lg:max-w-[700px] ">
      <p class="headerlineOne my-auto max-w-fit h-fit py-2  lg:pr-5">
        Tavaszi Mega Akció!
      </p>
      <div class="headerlineTwo max-w-fit">
        <ul class="mb-8 font-extrabold text-indigo-950">
          <li> Minden táplálékkiegészítő és vitamin</li>
          <li> Akár 30% kedvezménnyel, és</li>
          <li class="freeshipping w-fit mt-4 rounded-lg font-semibold p-1 text-sky-50 shadow-xl italic">
            Ingyenes kiszállítással!*
          </li>
          <div class="headerlineThree rounded">
            <span class="text-nowrap text-slate-800 font-light">
              *<b>Limitált ajánlat:</b> Május 22-31. között!
            </span>
          </div>
        </ul>
        <button class="checkitout transition-all ease-in-out duration-200 xl:mt-8">
          Megnézem
        </button>
      </div>
    </div>
    <div class="grid md:col-span-3 m-auto w-1/2 lg:w-full">
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
  padding: 7.5rem 1rem;
  display: flex;
  flex-direction: row;
  align-items: start;
}


.headerlineOne {
  font-size: clamp(2.2rem, 2.3vw, 3.7rem);
  text-shadow: 3px 4px 12px rgba(83, 4, 71, 0.9);
  color: White;
  letter-spacing: .1rem;
  font-weight: 700;
  margin-bottom: 1.6rem;
  text-wrap: nowrap;
}

.headerlineTwo {
  font-size: clamp(1rem, 2vw, 2.6rem);
  font-family: 'Nunito';

  @media screen and (max-width: 1024px) {
    min-width: 16rem;
    text-wrap: wrap;
  }

}

.freeshipping {
  background-color: rgb(159, 80, 159);
  padding: 0.2rem 0.6rem;
  margin-bottom: 1rem;
}

.headerlineThree {
  font-size: clamp(0.75rem, 1vw, 1.8rem);
}

.checkitout {
  font-size: clamp(1rem, 2vw, 1.4rem);
  font-weight: 800;
  letter-spacing: 1.5px;
  color: white;
  background-color: rgba(10, 159, 154, 0.834);
  border-radius: .5rem;
  padding: 0.5rem 1rem;
  box-shadow: 5px 0px 25px 3px rgba(33, 1, 33, 0.2);
  border: 2px solid rgb(255, 255, 255, 70%);
}

.checkitout:hover {
  font-size: clamp(1rem, 2vw, 1.4rem);
  font-weight: 800;
  letter-spacing: 1.5px;
  color: white;
  background-color: rgba(14, 192, 186, 0.834);
  border-radius: .5rem;
  padding: 0.5rem 1rem;
  box-shadow: 5px 0px 25px 3px rgba(33, 1, 33, 0.2);
  border: 2px solid rgb(255, 255, 255, 70%);
}

@media screen and (min-width:1024px) and (max-width:1536px) {
  #banner {
    display: flex;
    flex-direction: row;
    align-items: start;
    padding-top: 4rem;
    min-height: 100vh;
    background-position-x: 30%;
    background-position-y: top -3.5rem;
  }

  .headerlineOne {
    font-size: 2.5rem;
    width: max-content;
    margin-bottom: 1.2rem;
  }

  .headerlineTwo {
    min-width: 5rem;
    font-size: 1.7rem;
    line-height: 2.6rem;
  }

  .headerlineThree {
    font-size: 1rem;
    margin-top: 1rem;
    font-style: italic;
  }

  .freeshipping {
    min-width: 10rem;
    font-size: 1.2rem;
    margin-top: .8rem;
  }

  .checkitout {
    margin-top: 1.2rem;
  }
}

@media screen and (min-width:768px) and (max-width: 1024px) {
  #banner {
    display: flex;
    flex-direction: row;
    align-items: start;
    padding-top: 4rem;
    min-height: 100vh;
    background-position-x: 30%;
    background-position-y: top -3.5rem;
  }

  .headerlineOne {
    font-size: 1.8rem;
    width: max-content;
    margin-bottom: 1.2rem;
  }

  .headerlineTwo {
    min-width: 5rem;
    font-size: 1.3rem;
    line-height: 2rem;
  }

  .headerlineThree {
    font-size: 1rem;
    margin-top: 1rem;
    font-style: italic;
  }

  .freeshipping {
    min-width: 10rem;
    font-size: 1.2rem;
    margin-top: .8rem;
  }

  .checkitout {
    margin-top: 1.2rem;
  }

}


@media screen and (min-width:480px) and (max-width: 768px) {
  #banner {
    display: flex;
    flex-direction: row;
    align-items: start;
    padding-top: 4rem;
    min-height: 100vh;
    background-position-x: 30%;
    background-position-y: top -3.5rem;
  }

  .headerlineOne {
    font-size: 1.8rem;
    width: max-content;
    margin-bottom: 1.2rem;
  }

  .headerlineTwo {
    min-width: 5rem;
    font-size: 1.3rem;
    line-height: 2rem;
  }

  .headerlineThree {
    font-size: 0.9rem;
    margin-top: 1rem;
    font-style: italic;
  }

  .freeshipping {
    min-width: 10rem;
    font-size: 1.2rem;
    margin-top: .8rem;
  }

  .checkitout {
    margin-top: 1.2rem;
  }

}

@media screen and (max-width: 480px) {
  .headerlineOne {
    font-size: 1.7rem;
    width: max-content;
    margin-bottom: 1.2rem;
  }

  .headerlineTwo {
    min-width: 5rem;
    font-size: 1.3rem;
  }

  .headerlineThree {
    font-size: 0.9rem;
    margin-top: 0.75rem;
    font-style: italic;
  }

  .freeshipping {
    min-width: 10rem;
    font-size: 1.2rem;
    text-wrap: nowrap;
  }

  #banner {
    display: flex;
    flex-direction: row;
    align-items: start;
    padding-top: 4rem;
    min-height: 100vh;
    background-image: url('../assets/banners/banner.png');
    background-position-x: 25%;
    background-position-y: top -3.5rem;
  }
}
</style>
