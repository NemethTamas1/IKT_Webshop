<template>
    <BaseLayout>
        <div class="mx-auto w-full mb-[250px]">
            <div>
                <p class="text-3xl font-bold text-center my-4" style="font-family:'Nunito'">Vitaminok</p>
                <p class="font-2xl font-semibold text-center" style="font-family:'Nunito'">
                    A vitaminok az emberi szervezet számára nélkülözhetetlen, általában kis molekulatömegű olyan szerves
                    vegyületek, amelyeket az nem képes előállítani. Van olyan vitamin, mely egy adott enzim alkotórésze,
                    de akad olyan vitamin is, melynek önálló egységként van szerepe az anyagcserefolyamatok
                    szabályozásában. Akad olyan vitamin is, melyet a szervezet előanyagokból (provitaminok) képes
                    felépíteni (pl. az A-vitamin előanyaga a karotin). A vitaminok két nagy csoportra: zsírban és vízben
                    oldódóakra oszthatók. A zsírban oldódóakat a szervezet képes raktározni. A vízben oldódóakat naponta
                    kell fogyasztani, mivel a szervezetből kiürülnek.
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
                    <p class="text-xl font-bold mb-2">Összesen: {{ allVariants.length }} vitamin termék variáns</p>
                    <p>Egyedi termékek: {{ vitaminProducts.length }} | Márkák: {{ uniqueBrands.length }}</p>
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
                            <!-- <p v-if="variant.flavour" class="italic text-gray-600"> {{ variant.flavour }}</p> -->
                            <p v-if="variant.quantity" class="text-gray-600">{{ variant.quantity }} {{ variant.unit }}.
                            </p>
                        </router-link>
                        <div class="mt-4 flex justify-between items-center">
                            <p class="text-lg font-bold">
                                {{ formatPrice(variant.price) }} Ft
                            </p>
                            <button @click="addVariantToCart(variant)"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Kosárba
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from '@layouts/BaseLayout.vue';
import { useCartStore } from '@stores/CartStore';
import { useProductStore } from '@stores/ProductStore';
import { ToastService } from '@stores/ToastService';
import { computed, onMounted, ref } from 'vue';
import { RouterLink, useRouter } from 'vue-router';


const productStore = useProductStore();
const cartStore = useCartStore();

const error = ref(false);
const errorMessage = ref('');
const selectedBrand = ref(null);
const router = useRouter();
const baseProduct = ref(null);
const currentVariant = ref(null);
const selectedFlavour = ref('');
const selectedSize = ref('');
const loading = ref(true);


const vitaminProducts = computed(() => {
    return productStore.products.filter(product => {
        return product.available === 1 && product.category?.id === 3;
    });
});

console.log("Vitamin Products:");
vitaminProducts.value.forEach(p => {
    if (p.category?.id === 3) {
        console.log('product.name:', ' | ', p.name); // searchName
    }
});


const generateProductUrl = (variant) => {
    return `/${variant.product_name}-${variant.quantity}${variant.unit}-${variant.flavour}`;
};

const allVariants = computed(() => {
    const variants = [];

    vitaminProducts.value.forEach(product => {
        if (product.productvariants) {
            if (Array.isArray(product.productvariants) && product.productvariants.length > 0) {
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
            } else if (product.productvariants && typeof product.productvariants === 'object') {
                // Ha nincs más variáns. Csak egyetlen objektum az egész
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
        } else {
            // Ha nincs más variáns. Különálló termék
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
    });

    return variants;
});

const addVariantToCart = (variant) => {
    const product = {
        id: variant.id,
        name: variant.product_name,
        price: variant.price,
        image: variant.image_path,
        flavour: variant.flavour,
        quantity: variant.quantity,
        unit: variant.unit,
        brand: variant.brand_name
    }

    cartStore.addToCart(product);
    ToastService.showSuccess("Termék sikeresen hozzáadva a kosárhoz!");
}


// Szűrt variánsok Márka! alapján
const filteredVariants = computed(() => {
    if (selectedBrand === null) {
        return allVariants.value.filter(variant => variant.brand_id != null)
    }

    return allVariants.value.filter(variant => variant.brand_id === selectedBrand.value);
});

// Egyedi (szelektált) márkák
const uniqueBrands = computed(() => {
    const brandsMap = new Map();

    vitaminProducts.value.forEach(product => {
        if (product.brand && product.brand.id && product.brand.name) {
            brandsMap.set(product.brand.id, product.brand);
        }
    });

    return Array.from(brandsMap.values());
});

// Márka "szűrő" váltása
const toggleBrandFilter = (brandId) => {
    selectedBrand.value = brandId;
};

// Árak formázása
const formatPrice = (price) => {
    return price ? price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") : "0";
};

const loadProducts = async () => {
    try {
        loading.value = true;

        if (productStore.products.length === 0) {
            await productStore.getProducts();
        }

        // Vitamin kategóriájú termékek szűrése (category id === 3)
        const vitaminProducts = productStore.products.filter(p => p.category?.id === 3);
        console.log('vitamin products: ', vitaminProducts)

        if (vitaminProducts.length === 0) {
            console.warn("Nincsenek vitamin kategóriájú termékek.");
            return;
        }

        for (const product of vitaminProducts) {
            const variant = product.productvariants?.[0];

            if (variant) {
                console.log('próbálom betölteni...: ', variant);
                console.log("Betöltött vitamin (variánssal):", product.brand.name, product.name);

                baseProduct.value = product;
                currentVariant.value = variant;
                selectedFlavour.value = variant.flavour || '';
                selectedSize.value = variant.quantity;
            } else {
                console.warn("Nincs variáns, de betöltöm a fő termékadatokat:", product.name);

                // Itt a product alapján töltünk be
                baseProduct.value = product;
                currentVariant.value = null;
                selectedFlavour.value = '';
                selectedSize.value = null;
            }

            console.log('product objektum: ', product);
        }

    } catch (error) {
        console.error("Hiba a vitamin termékek betöltése során:", error);
    } finally {
        loading.value = false;
    }
};


onMounted(async () => {
    await loadProducts();
});
</script>
