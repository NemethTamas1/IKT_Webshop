<template>
    <BaseLayout>
        <div class="mx-auto w-full mb-[250px]">
            <div>
                <p class="text-3xl font-bold text-center my-4" style="font-family:'Nunito'">Multivitaminok</p>
                <p class="font-2xl font-semibold text-center" style="font-family:'Nunito'">
                    A szervezetbe kerülő vitaminok egymáshoz viszonyított aránya rendkívül fontos, ezért érdemes a komplex multivitamin készítményeket előnyben részesíteni a különálló vitamin készítményekkel szemben. Mint minden esetben, itt is elsősorban a helyes táplálkozásra kell törekedni, és ezt kiegészíteni - és nem helyettesíteni - a megfelelő multivitamin készítmények fogyasztásával.
                </p>
            </div>

            <!-- Betöltés -->
            <div v-if="loading" class="text-center py-10">
                <div class="flex justify-center">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-gray-900"></div>
                </div>
                <p class="text-xl mt-4">Termékek betöltése...</p>
            </div>

            <!-- Fehérje termékek megjelenítése -->
            <div v-else>
                <div class="bg-gray-100 p-3 rounded-lg mb-4">
                    <p class="text-xl font-bold mb-2">Összesen: {{ allVariants.length }} multivitamin termék variáns</p>
                    <p>Egyedi termékek: {{ multivitaminProducts.length }} | Márkák: {{ uniqueBrands.length }}</p>
                </div>

                <div class="flex flex-wrap gap-4 my-6 p-3 justify-center">
                    <button v-for="brand in uniqueBrands" :key="brand.id" @click="toggleBrandFilter(brand.id)"
                        class="px-3 py-1 rounded-full text-lg font-semibold mr-2 mb-2 transition duration-200 ease-in-out"
                        :class="selectedBrand === brand.id ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300'">
                        {{ brand.name }}
                    </button>
                </div>

                <div v-if="filteredVariants.length > 0"
                    class="grid grid-cols-1 md:grid-cols- lg:grid-cols-4 gap-10 p-4 ">
                    <div v-for="variant in filteredVariants" :key="`${variant.id}`"
                        class="mx-auto mt-12 p-4 w-full rounded-lg bg-gray-100/50 border-b-4 border-r-4 border-sky-700/35 shadow-xl overflow-hidden hover:border-lime-700/55 transition-all duration-500 ease-in-out cursor-pointer">
                        <router-link :to="generateProductUrl(variant)">
                            <div class="h-40 flex justify-center items-center mb-4">
                                <img v-if="variant.image_path" :src="`/src/assets/products_img/${variant.image_path}`"
                                    :alt="variant.product_name" class="max-h-full max-w-full object-contain">
                                <div v-else class="bg-gray-200 w-full h-full flex items-center justify-center">Nincs kép
                                </div>
                            </div>
                            <p v-if="variant.brand_name" class="text-lg text-gray-600 mt-1">{{ variant.brand_name }}</p>
                            <h3 class="text-lg font-semibold">{{ variant.product_name }}</h3>
                            <p v-if="variant.flavour" class="italic text-gray-600"> {{ variant.flavour }}</p>
                            <p v-if="variant.quantity" class="text-gray-600">{{ variant.quantity }} {{ variant.unit}}.</p>
                            <div class="mt-4 flex justify-between items-center">
                                <p class="text-lg font-bold">
                                    {{ formatPrice(variant.price) }} Ft
                                </p>
                                <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Kosárba
                                </button>
                            </div>
                        </router-link>
                    </div>

                </div>

                <div v-else class="text-center py-10">
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </BaseLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import BaseLayout from '@layouts/BaseLayout.vue';
import { useProductStore } from '@stores/ProductStore';
import { RouterLink, useRouter } from 'vue-router';


const productStore = useProductStore();
const loading = ref(true);
const error = ref(false);
const errorMessage = ref('');
const selectedBrand = ref(null);
const router = useRouter();


const multivitaminProducts = computed(() => {

    //slug
    const nameKeywords = [
        'mega-daily-one',
        'multi-pro-plus',
        'vitaday',
        'vitapropack',
        'dailyhealt',
    ];

    const descriptionKeywords = [
        'multivitamin',
        'kálcium',
        'komplex multivitamin',
    ];

    const productLineKeywords = [
        'megadailyone',
        'multiproplus',
        'vitaday',
        'vitapropack',
        'dailyhealt',
    ];

    const categoryNameMatch = ['multivitamin', 'vitamin'];
    const categoryDescKeywords = ['vitaminok', 'multivitaminok'];

    return productStore.products.filter(product => {
        if (product.available !== 1) return false;

        const name = product.name?.toLowerCase() || '';
        const description = product.description?.toLowerCase() || '';
        const productLine = product.product_line?.toLowerCase() || '';
        const categoryName = product.category?.name?.toLowerCase() || '';
        const categoryDescription = product.category?.description?.toLowerCase() || '';

        return (
            categoryNameMatch.includes(categoryName) ||
            categoryDescKeywords.some(keyword => categoryDescription.includes(keyword)) ||
            nameKeywords.some(keyword => name.includes(keyword)) ||
            descriptionKeywords.some(keyword => description.includes(keyword)) ||
            productLineKeywords.some(keyword => productLine.includes(keyword))
        );
    });
});

// Minden variáns egy lapos listában
const allVariants = computed(() => {
    const variants = [];    

    multivitaminProducts.value.forEach(product => {
        if (product.productvariants) {
            if (Array.isArray(product.productvariants)) {
                product.productvariants.forEach(variant => {
                    variants.push({
                        id: variant.id,
                        product_id: product.id,
                        product_name: product.name,
                        description: product.description,
                        flavour: variant.flavour,
                        quantity: variant.quantity,
                        unit: variant.unit,
                        price: variant.price,
                        image_path: variant.image_path || (product.image ? product.image : null),
                        brand_id: product.brand ? product.brand.id : null,
                        brand_name: product.brand ? product.brand.name : null,
                        available: variant.available !== undefined ? variant.available : product.available
                    });
                });
            } else {
                // Ha a productvariants egyetlen objektum
                const variant = product.productvariants;
                variants.push({
                    id: variant.id,
                    product_id: product.id,
                    product_name: product.name,
                    description: product.description,
                    flavour: variant.flavour,
                    quantity: variant.quantity,
                    unit: variant.unit,
                    price: variant.price,
                    image_path: variant.image_path || (product.image ? product.image : null),
                    brand_id: product.brand ? product.brand.id : null,
                    brand_name: product.brand ? product.brand.name : null,
                    available: variant.available !== undefined ? variant.available : product.available
                });
            }
        }
    });

    return variants;
});
const generateProductUrl = (variant) => {
  // Ha a termék neve Jumbo!, akkor azt használjuk az URL-ben
  const urlName = variant.product_name === 'Jumbo!' ? 'Jumbo!' : variant.brand_name;
  return `/${urlName}-${variant.quantity}gr-${variant.flavour}`;
};

// Szűrt variánsok márka alapján
const filteredVariants = computed(() => {
    if (selectedBrand === null) {
        return allVariants.value.filter(variant => variant.brand_id != null)
    }

    return allVariants.value.filter(variant => variant.brand_id === selectedBrand.value);
});

// Egyedi márkák
const uniqueBrands = computed(() => {
    const brandsMap = new Map();

    multivitaminProducts.value.forEach(product => {
        if (product.brand && product.brand.id && product.brand.name) {
            brandsMap.set(product.brand.id, product.brand);
        }
    });

    return Array.from(brandsMap.values());
});

// Márka szűrő váltás
const toggleBrandFilter = (brandId) => {
    selectedBrand.value = brandId;
};

// Árak formázása
const formatPrice = (price) => {
    return price ? price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") : "0";
};

const loadProducts = async () => {
    loading.value = true;
    error.value = false;
    errorMessage.value = '';

    try {
        await productStore.getProducts();


        if (multivitaminProducts.value.length === 0) {
            errorMessage.value = "Nem található fehérje termék";
            error.value = true;
        } else if (allVariants.value.length === 0) {
            errorMessage.value = "A fehérje termékekhez nem találhatók variánsok";
            error.value = true;
        } else {
        }
    } catch (err) {
        console.error("Hiba a termékek lekérdezésekor:", err);
        error.value = true;
        errorMessage.value = `Hiba történt: ${err.message || 'Ismeretlen hiba'}`;
    } finally {
        loading.value = false;
    }
};

onMounted(async () => {
    await loadProducts();
});
const navigateToProductDetails = (variant) => {
    router.push({
        name: 'ProductDetails',
        params: {
            brand: variant.brand_name,
            quantity: variant.quantity,
            flavour: variant.flavour
        }
    });
};
</script>

