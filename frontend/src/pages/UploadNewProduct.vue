<template>
    <BaseLayout>
        <div v-if="isLoading || !productStore.categoryTypes.length">
            <BaseSpinner class="mt-5 mx-auto" />
        </div>
        <div v-else>

            <h1 class="text-4xl mt-5">Új termék felvétele</h1>

            <FormKit type="form" :actions="false" @submit="handleForm">

                <!-- Kategória -->
                <FormKit label-class="text-sky-600 text-2xl" input-class="w-6/12 p-2 rounded-lg border border-gray-500"
                    v-model="categoryValue" placeholder="Válasszon kategóriát!" type="select" name="" label="Kategória"
                    validation="" :options="productStore.categoryOptions" />

                <!-- Márka -->
                <FormKit label-class="text-sky-600 text-2xl" input-class="w-6/12 p-2 rounded-lg border border-gray-500"
                    v-model="brandValue" type="select" placeholder="Válasszon márkát!" name="" label="Márka"
                    validation="" :options="productStore.brandOptions" />

                <!-- Név -->
                <FormKit label-class="text-sky-600 text-2xl" input-class="w-6/12 p-2 rounded-lg border border-gray-500"
                    v-model="name" type="text" name="" label="Termék neve" validation="" />

                <!-- Leírás -->
                <FormKit label-class="text-sky-600 text-2xl" input-class="w-6/12 p-2 rounded-lg border border-gray-500"
                    v-model="description" type="text" name="" label="Leírás" validation="" />

                <!-- Termékcsalád -->
                <FormKit label-class="text-sky-600 text-2xl" input-class="w-6/12 p-2 rounded-lg border border-gray-500"
                    v-model="productLine" type="select" name="" label="Termékcsalád" validation=""
                    :options="productStore.productLineOptions" placeholder="Válasszon termékcsaládot!" />

                <!-- Elérhető -->
                <FormKit label-class="text-sky-600 text-2xl" input-class="w-6/12 p-2 rounded-lg border border-gray-500"
                    v-model="available" type="select" name="" label="Elérhető" validation=""
                    :options="productStore.availabilityOptions" placeholder="Válasszon elérhetőséget!" />

                <button type="submit" class="bg-sky-600 p-2 rounded-lg text-white mt-4">
                    Új termék felvétele
                </button>
            </FormKit>
        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from '@layouts/BaseLayout.vue';
import { useProductStore } from '@stores/ProductStore.mjs';
import BaseSpinner from '@components/layout/BaseSpinner.vue';
import { onMounted, ref, computed } from 'vue';

const productStore = useProductStore();

const isLoading = ref(false);
const categories = ref(null);
const brands = ref(null);
const categoryValue = ref('');
const brandValue = ref('');
const name = ref('');
const description = ref('');
const productLine = ref('');
const available = ref(null);

const slug = computed(() => {
    return name.value
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .trim()
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
});

const handleForm = async() => {
    console.log('CategoryID: ', Number(categoryValue.value));
    console.log('BrandID: ', Number(brandValue.value));
    console.log('Name: ', name.value);
    console.log('Slug: ', slug.value);
    console.log('Description: ', description.value);
    console.log('ProductLine: ', productLine.value);
    console.log('Available: ', available.value);

    const data = {
        category_id: Number(categoryValue.value),
        brand_id: Number(brandValue.value),
        name: name.value,
        slug: slug.value,
        description: description.value,
        product_line: productLine.value,
        available: available.value,
    }

    await productStore.createProduct(data);
    alert("siker");
};

onMounted(async () => {
    isLoading.value = true;
    categories.value = await productStore.getCategories();
    brands.value = await productStore.getBrands();
    isLoading.value = false;
})



// NEW PRODUCT
// category_id  => dropdown
// brand_id     => dropdown
// name         => text
// slug         => computed
// description  => text
// product_line => dropdown
// available    => dropdown
</script>