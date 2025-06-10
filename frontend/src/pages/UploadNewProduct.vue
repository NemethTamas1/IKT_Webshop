<template>
    <BaseLayout>
        <div v-if="isLoading || !productStore.categoryTypes.length">
            <BaseSpinner class="mt-5 mx-auto" />
        </div>
        <div v-else class="">
            <h1
                class="w-full h-full mx-auto text-center text-4xl mt-5 text-sky-50 bg-gradient-to-r from-transparent via-sky-600 to-transparent py-6 font-extrabold">
                Új termék felvétele
            </h1>
            <div class="grid grid-cols-1 md:grid-cols-2 mx-auto mt-8 w-4/5 justify-center align-middle items-center">
                <div class="w-full h-full">
                    <FormKit type="form" :actions="false" @submit="handleForm">
                        <!-- Kategória -->
                        <FormKit label-class="text-sky-600 text-2xl w-full"
                            input-class="w-6/12 w-full p-2 mt-1 mb-4 rounded-lg border border-gray-500"
                            v-model="categoryValue" placeholder="Válasszon kategóriát!" type="select" name=""
                            label="Kategória" validation="" :options="productStore.categoryOptions" />

                        <!-- Márka -->
                        <FormKit label-class="text-sky-600 text-2xl"
                            input-class="w-6/12 p-2 mt-1 mb-4 rounded-lg border border-gray-500" v-model="brandValue"
                            type="select" placeholder="Válasszon márkát!" name="" label="Márka" validation=""
                            :options="productStore.brandOptions" />

                        <!-- Név -->
                        <FormKit label-class="text-sky-600 text-2xl"
                            input-class="w-6/12 p-2 mt-1 mb-4 rounded-lg border border-gray-500" v-model="name"
                            type="text" name="" label="Termék neve" validation="" />

                        <!-- Leírás -->
                        <FormKit label-class="text-sky-600 text-2xl"
                            input-class="w-6/12 p-2 mt-1 mb-4 rounded-lg border border-gray-500" v-model="description"
                            type="text" name="" label="Leírás" validation="" />

                        <!-- Termékcsalád -->
                        <FormKit label-class="text-sky-600 text-2xl"
                            input-class="w-6/12 p-2 mt-1 mb-4 rounded-lg border border-gray-500" v-model="productLine"
                            type="select" name="" label="Termékcsalád" validation=""
                            :options="productStore.productLineOptions" placeholder="Válasszon termékcsaládot!" />

                        <!-- Elérhető -->
                        <FormKit label-class="text-sky-600 text-2xl"
                            input-class="w-6/12 p-2 mt-1 mb-4 rounded-lg border border-gray-500" v-model="available"
                            type="select" name="" label="Elérhető" validation=""
                            :options="productStore.availabilityOptions" placeholder="Válasszon elérhetőséget!" />

                        <div class="space-x-4 mx-auto mt-2 w-full">
                            <button type="button" @click="resetForm"
                                class="hover:bg-yellow-600 bg-yellow-500 py-3 px-4 rounded-lg text-white font-semibold transition-colors duration-200">
                                Újrakezdés
                            </button>
                            <button type="submit"
                                class="hover:bg-green-600 bg-green-500 py-3 px-4 rounded-lg text-white font-semibold transition-colors duration-200">
                                Létrehozás véglegesítése
                            </button>
                        </div>
                    </FormKit>
                </div>

                <div class="mx-auto w-full h-full">
                    <BaseProductImageUploader ref="imageUploader" @image-selected="selectedImage" />
                </div>
            </div>
        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from '@layouts/BaseLayout.vue';
import { useProductStore } from '@stores/ProductStore.mjs';
import BaseSpinner from '@components/layout/BaseSpinner.vue';
import BaseProductImageUploader from '@components/layout/BaseProductImageUploader.vue';
import { onMounted, ref, computed } from 'vue';
import { useUserStore } from '@stores/UserStore';
import { useRouter } from 'vue-router';

const productStore = useProductStore();
const userStore = useUserStore();

const router = useRouter();

const isLoading = ref(false);
const categories = ref(null);
const brands = ref(null);
const categoryValue = ref('');
const brandValue = ref('');
const name = ref('');
const description = ref('');
const productLine = ref('');
const available = ref(null);
const productImage = ref(null);
const imageUploader = ref(null);

const slug = computed(() => {
    return name.value
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .trim()
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
});

const selectedImage = (imageData) => {
    if (imageData) {
        productImage.value = imageData;
    } else {
        productImage.value = null;
    }
};

const resetForm = () => {
    name.value = '';
    description.value = '';
    productLine.value = '';
    categoryValue.value = '';
    brandValue.value = '';
    available.value = true;
    productImage.value = null;

    // Képfeltöltő resetelés
    if (imageUploader.value) {
        imageUploader.value.clearImage();
    }
};

const handleForm = async () => {
    if (!productImage.value) {
        alert('Kérjük töltsön fel egy képet!');
        return;
    }
    const formData = new FormData();
    formData.append('category_id', Number(categoryValue.value));
    formData.append('brand_id', Number(brandValue.value));
    formData.append('name', name.value);
    formData.append('slug', slug.value);
    formData.append('description', description.value);
    formData.append('product_line', productLine.value);
    formData.append('available', available.value);

    if (productImage.value && productImage.value.file) {
        formData.append('image', productImage.value.file);
    }

    try {
        await productStore.createProduct(formData);
        alert("Termék sikeresen létrehozva!");
        resetForm();
    } catch (error) {
        console.error('Hiba a termék létrehozásakor:', error);
        alert('Hiba történt a termék létrehozásakor!');
    }
};

onMounted(async () => {
    if(!userStore.isAdmin || !userStore.isLoggedIn) {
        router.replace('/');
        return;
    }

    isLoading.value = true;
    categories.value = await productStore.getCategories();
    brands.value = await productStore.getBrands();
    isLoading.value = false;
});
</script>
