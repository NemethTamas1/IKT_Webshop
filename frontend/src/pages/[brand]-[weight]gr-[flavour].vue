<template>
  <BaseLayout>
    <div v-if="!loading" class="grid grid-cols-3 gap-4 w-full bg-red-500">
      <!-- Kép bal oldalon -->
      <img 
        :src="getImagePath(
          product.categories[0].brand,
          product.weight,
        product.flavour,
        product.description
      )"
        :alt="product.description"
        class="w-full h-full object-contain col-span-1" 
      />

      <!-- Információk a jobb oldalon -->
      <div class="col-span-2 space-y-2">
        <h1 class="text-xl font-semibold">{{ product.categories[0].brand }}</h1>
        <p class="text-lg">{{ product.description }} ({{ product.weight }}gr)</p>
        <p class="text-lg">{{ product.price }} Ft</p>
        <p v-if="product.categories[0].available=1">Raktáron</p>
        <p v-else>Nincs raktáron</p>
        <FormKit label="Íz" type="select"/> <!-- :options=""-el fel kell tölteni -->
        <p>Darabszám</p><!-- Itt bele kell implementálni egy számlálót -->
      </div>
    </div>
  </BaseLayout>
</template>



  

<script setup>
//Importok
import BaseLayout from '@layouts/BaseLayout.vue';
import {useProductStore} from '@stores/ProductStore';
import { onMounted, computed, ref } from 'vue';
import { useRoute } from 'vue-router';

//Változók
const productStore = useProductStore();
const route = useRoute();
const product = computed(() => productStore.oneProduct[0] ?? null);
const loading = ref(true);
const images = import.meta.glob('@/assets/products_img/**/*.webp', { eager: true })

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



onMounted(async ()=>{
  await productStore.getProducts();
  await productStore.sortGetOneProduct(
    route.params.brand,
    Number(route.params.weight),
    route.params.flavour);

  loading.value=false;
})
</script>