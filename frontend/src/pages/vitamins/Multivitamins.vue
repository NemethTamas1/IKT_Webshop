<template>
    <BaseLayout>
        <div class="mx-auto w-full mb-[250px]">
            <div>
                <p class="text-3xl font-bold text-center my-4" style="font-family:'Nunito'">Multivitaminok</p>
                <p class="font-2xl font-semibold text-center" style="font-family:'Nunito'">
                    A szervezetbe kerülő vitaminok egymáshoz viszonyított aránya rendkívül fontos, ezért érdemes a
                    komplex multivitamin készítményeket előnyben részesíteni a különálló vitamin készítményekkel
                    szemben. Mint minden esetben, itt is elsősorban a helyes táplálkozásra kell törekedni, és ezt
                    kiegészíteni - és nem helyettesíteni - a megfelelő multivitamin készítmények fogyasztásával.
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
import { useCartStore } from '@stores/CartStore';
import { ToastService } from '@stores/ToastService';


const productStore = useProductStore();
const cartStore = useCartStore();

const loading = ref(true);
const error = ref(false);
const errorMessage = ref('');
const selectedBrand = ref(null);
const router = useRouter();


const multivitaminProducts = computed(() => {
    const nameKeywords = [
        'mega-daily-one',
        'multi-pro-plus',
        'vitaday',
        'vitapropack',
        'dailyhealt',
    ];

    return productStore.products.filter(product => {
        if (product.available !== 1) return false;

        // Pontos név egyezés ellenőrzése
        const exactNameMatch = nameKeywords.some(keyword =>
            product.name?.toLowerCase() === keyword
        );

        if (exactNameMatch) return true;

        // Kategória alapján szűrés
        if (product.category?.name?.toLowerCase() === 'multivitamin') return true;

        return false;
    });
});
const generateProductUrl = (variant) => {
    return `/${variant.product_name}-${variant.quantity}${variant.unit}-${variant.flavour}`;
};

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

    multivitaminProducts.value.forEach(product => {
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

const loadProducts = async (searchName, quantity, flavour) => {
    try {
        loading.value = true;

        if (productStore.products.length === 0) {
            await productStore.getProducts();
        }

        // Először keressük meg a terméket név alapján
        let product = productStore.products.find(p => p.name === searchName);

        // Ha nincs találat név alapján, próbáljuk brand alapján
        if (!product) {
            product = productStore.products.find(p => {
                return p.brand?.name === searchName &&
                    p.productvariants?.some(v => {
                        // Tisztítsuk meg a mennyiséget az egységtől
                        const cleanQuantity = String(quantity).replace(/[a-zA-Z]/g, '').trim();
                        return String(v.quantity) === cleanQuantity;
                    });
            });
        }

        if (!product) {
            console.error('Nem található termék:', { searchName, quantity });
            loading.value = false;
            return;
        }

        // Variáns keresése
        const variant = product.productvariants?.find(v => {
            // Tisztítsuk meg a mennyiséget az egységtől
            const cleanInputQuantity = String(quantity).replace(/[a-zA-Z]/g, '').trim();
            const quantityMatch = String(v.quantity) === cleanInputQuantity;
            const flavourMatch = !flavour || v.flavour?.toLowerCase() === flavour?.toLowerCase();

            return quantityMatch && flavourMatch;
        });

        if (!variant) {
            console.error('Nem található variáns:', { quantity, flavour });
            loading.value = false;
            return;
        }

        baseProduct.value = product;
        currentVariant.value = variant;
        selectedFlavour.value = variant.flavour || '';
        selectedSize.value = variant.quantity;

    } catch (error) {
        console.error('Hiba a termék betöltése során:', error);
    } finally {
        loading.value = false;
    }
};
onMounted(async () => {
    await loadProducts();
});
</script>
