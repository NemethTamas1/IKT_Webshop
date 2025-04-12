<template>
    <BaseLayout>
        <div v-if="linkText === '/brands/scitec'" class="w-full h-full mb-24">
            <p class="text-3xl font-extrabold my-8 underline underline-offset-4 text-center">
                Scitec Nutrition
            </p>
            <div class="scitec grid grid-cols-2 mx-auto mb-24">
                <!-- Csak a kép helye -->
            </div>
            <div>
                <BaseProductCard :products="productStore.filtered" />
            </div>
        </div>

        <div v-else-if="linkText === '/brands/builder'" class="w-full h-full mb-24">
            <p class="text-3xl font-extrabold my-2 underline underline-offset-4 text-center mb-8">
                Builder
            </p>
            <div class="builder grid grid-cols-2 mx-auto mb-24">
                <!-- Csak a kép helye -->
            </div>
            <div>
                <BaseProductCard :products="productStore.filtered" />
            </div>
        </div>

        <div v-else-if="linkText === '/brands/pronutrition'" class="w-full h-full mb-24">
            <p class="text-3xl font-extrabold my-2 underline underline-offset-4 text-center mb-8">
                Pro Nutrition
            </p>
            <div class="pronutrition grid grid-cols-2 mx-auto mb-24">
                <!-- Csak a kép helye -->
            </div>
            <div>
                <BaseProductCard :products="productStore.filtered" />
            </div>
        </div>
    </BaseLayout>
</template>
<script setup>
import BaseLayout from '@layouts/BaseLayout.vue';
import BaseProductCard from '@layouts/BaseProductCard.vue';
import { useRoute } from 'vue-router';
import { watch, ref, onMounted } from 'vue';
import { useProductStore } from '@stores/ProductStore.mjs';

const productStore = useProductStore();
const route = useRoute();
const linkText = ref(route.path);

const filterByBrand = async (path) => {
    try {
        if (path === '/brands/scitec') {
            await productStore.sortProductsByBrand('Scitec');
        } else if (path === '/brands/pronutrition') {
            await productStore.sortProductsByBrand('Pro Nutrition');
        } else if (path === '/brands/builder') {
            await productStore.sortProductsByBrand('Builder');
        }
    } catch (error) {
        console.error('Hiba a szűrésnél:', error);
    }
};

onMounted(async () => {
    try {
        await productStore.getProducts();
        await filterByBrand(route.path);
    } catch (error) {
        console.error('Hiba a kezdeti betöltésnél:', error);
    }
});
watch(
    () => route.path,
    async (newPath) => {
        linkText.value = newPath;
        console.log('Útvonal változott:', newPath);
        await filterByBrand(newPath);
    },
    { immediate: true }
);
</script>
<style>
.builder,
.scitec,
.pronutrition {
    height: 500px;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
}

.scitec {
    background-image: url('@assets/banners/scitec_banner.jpg');
}

.builder {
    background-image: url('../../assets/banners/builder_banner.png');
}

.pronutrition {
    background-image: url('@assets/banners/pronutrition_banner.jpg');
}
</style>