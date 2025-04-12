<template>
    <BaseLayout>
        <h1 style="color: red;">{{ product.categories[0]?.brand }} {{ product.weight }} {{ product.flavour }}</h1>
  
        <img
          :src="getImagePath(
            product.categories[0]?.brand,
            product.weight,
            product.flavour,
            product.description
          )"
          :alt="product.description"
        />
      </div>
    </BaseLayout>
  </template>
  

<script setup>
import BaseLayout from '@layouts/BaseLayout.vue';
import {useProductStore} from '@stores/ProductStore';
import { onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';

const productStore = useProductStore();
const route = useRoute();

const product = computed(() => productStore.filtered[0] ?? null);
console.log("Termék: ", product)

const images = import.meta.glob('@/assets/products_img/**/*.webp', { eager: true })

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
    )

    console.log("brand", brand)
    console.log("subfolder", subfolder)
    console.log("weight", weight)
    console.log("flavour", flavour)


    return key ? images[key].default : ''
}

onMounted(async ()=>{
    await productStore.getProducts();
    await productStore.sortGetOneProduct(route.params.brand, Number(route.params.weight), route.params.flavour);
})
</script>