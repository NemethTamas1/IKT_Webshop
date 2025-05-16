<template>
  <BaseLayout>
    <div v-if="!isLoading" class="mx-auto">
      <div class="flex justify-center items-center w-full mt-16 h-full mx-auto">
        <div class="grid grid-cols-5 ">
          <!-- Kép szekció -->
          <div class="grid col-span-2 w-full xl:w-10/12 h-full xl:h-3/5">
            <img :src="`/src/assets/products_img/${currentVariant?.image_path}`" :alt="currentVariant?.flavour"
              class="flex justify-center items-center m-auto w-full mx-auto bg-white "
              :class="isProNutritionDailyHealthComplex || isDailyHealthKalciumMagnezium || isProNutritionDailyHealthCVitamin ? 'w-8/12 ' : 'w-full'" />
          </div>
          <!-- Termék details -->
          <div class="w-2/3 h-full  ml-6 flex-col justify-center col-span-3
           space-y-2 bg-gray-200 p-6 mx-2 rounded-lg shadow-md">
            <!-- Brand full neve -->
            <p class="my-2 pl-4 text-xl font-light uppercase">
              {{ baseProduct?.brand?.description }}
            </p>
            <!-- Term. név + mennyiség -->
            <p class="my-2 font-extrabold sm:text-lg md:text-xl lg:text-4xl">
              {{ baseProduct?.name }}
              <span class="text-gray-600 text-sm md:text-md lg:text-lg italic">({{ currentVariant?.quantity }} {{
                currentVariant?.unit
                }}.)</span>
            </p>

            <!-- Ár -->
            <p class="my-2 font-bold sm:text-lg md:text-xl lg:text-4xl">
              {{ productStore.formatToOneThousandPrice((currentVariant?.price)) }} Ft
            </p>

            <!-- Kg ár -->
            <p v-if="currentVariant?.price && currentVariant?.quantity && currentVariant.unit == 'gr'"
              class="my-2 font-semibold italic text-gray-500 text-xl">
              {{ productStore.formatToOneThousandPrice(calculatePricePerKg) }} Ft/kg
            </p>

            <!-- Készlet státusza -->
            <p v-if="currentVariant?.available === 1" class="my-2 font-bold text-green-500">
              Készleten
            </p>
            <p v-else class="my-2 font-bold text-red-500">
              Elfogyott
            </p>

            <!-- Kiszerelés options -->
            <div class="select-container" v-if="showSizesSelect">
              <label class="block text-lg font-medium">Kiszerelés:</label>
              <select v-model="selectedSize" @change="handleSizeChange"
                class="my-2 block min-w-fit py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                <option v-for="size in availableSizes" :key="size" :value="size">
                  {{ size }} {{ currentVariant?.unit }}
                </option>
              </select>
            </div>

            <!-- Ízesítés options -->
            <div class="select-container mt-6" v-if="availableFlavours.length && currentVariant.unit == 'gr'">
              <label class="block text-lg font-medium">Ízesítés:</label>
              <select v-model="selectedFlavour" @change="handleFlavourChange"
                class="mt-1 block max-w-fit py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                <option v-for="flavour in availableFlavours" :key="flavour" :value="flavour">
                  {{ flavour }}
                </option>
              </select>
            </div>

            <div class="mt-4 flex justify-between items-center">
              <button @click="addVariantToCart(currentVariant)"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Kosárba
              </button>
            </div>

          </div>
        </div>
      </div>
      <div>

        <ProductDetailsInformations :brand="baseProduct?.brand?.name" :product="baseProduct?.name"
          :description="currentVariant?.flavour" :isMultiProPlus="isMultiProPlus" :isVitaproPack="isVitaproPack"
          :isJumbo="isJumboProduct" :isVitaDay="isBuilderVitaDay" :isMegaDaily="isMegaDailyProduct"
          :isBuilderCvitamin="isBuilderCvitaminProduct" :categoryName="baseProduct?.category?.name"
          :isProNutritionDailyHealthComplex="isProNutritionDailyHealthComplex"
          :isDailyHealthKalciumMagnezium="isDailyHealthKalciumMagnezium"
          :isProNutritionDailyHealthCVitamin="isProNutritionDailyHealthCVitamin" 
          :isScitecCalciumMagnesium="isScitecCalciumMagnesium"/>
      </div>
    </div>

    <!-- Betöltő képernyő -->
    <div v-else class="flex justify-center items-center h-64">
      <div class="text-xl text-gray-500">Betöltés...</div>
    </div>
  </BaseLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useProductStore } from '@stores/ProductStore';
import BaseLayout from '@layouts/BaseLayout.vue';
import ProductDetailsInformations from '@layouts/ProductDetailsInformations.vue';
import { ToastService } from '@stores/ToastService.js'
import { useCartStore } from '@stores/CartStore.js';


const route = useRoute();
const router = useRouter();
const productStore = useProductStore();
const cartStore = useCartStore();

const isLoading = ref(true);
const baseProduct = ref(null);
const currentVariant = ref(null);
const selectedFlavour = ref('');
const selectedSize = ref('');

console.log('searchName paraméter:', route.params.brand);
console.log('quantity paraméter:', route.params.quantity);
console.log('flavour paraméter:', route.params.branflavourd);

console.log('currentVariant: ', currentVariant)

const addVariantToCart = async (variant) => {
  const productData = await productStore.getProduct(variant.product_id);
  console.log('productData.product_id: ', productData.product_id)

  if (!productData) {
    ToastService.showError("Nem sikerült a terméket betölteni.");
    return;
  }

  const product = {
    id: variant.id,
    name: productData.name,
    price: variant.price,
    image: productData.image_path,
    flavour: productData.flavour,
    quantity: productData.quantity,
    unit: productData.unit,
    brand: productData.brand_name
  }

  cartStore.addToCart(product);
  ToastService.showSuccess("Termék sikeresen hozzáadva a kosárhoz!");
}

const isScitecCalciumMagnesium = computed(() => {
  return baseProduct.value?.name === 'Calcium Magnesium';
});

const isProNutritionDailyHealthCVitamin = computed(() => {
  return baseProduct.value?.name === 'Daily Health C Vitamin';
});

const isDailyHealthKalciumMagnezium = computed(() => {
  return baseProduct.value?.name === 'Daily Health Kalcium Magnezium';
});

const isMultiProPlus = computed(() => {
  return baseProduct.value?.name === 'Multi Pro Plus';
});

const isProNutritionDailyHealthComplex = computed(() => {
  return baseProduct.value?.name === "Daily Health Komplex";
});
const isVitaproPack = computed(() => {
  return baseProduct.value?.name === 'Vitapro Pack';
});

const isMegaDailyProduct = computed(() => {
  return baseProduct.value?.name === 'Mega Daily One' ||
    baseProduct.value?.product_line === 'MegaDaily';
});

const isBuilderVitaDay = computed(() => {
  return baseProduct.value?.name === 'Vitaday';
});
const isBuilderCvitaminProduct = computed(() => {
  return baseProduct.value?.name === 'C vitamin'
});

const isJumboProduct = computed(() => {
  return baseProduct.value?.slug === 'Jumbo!' ||
    baseProduct.value?.name?.includes('Jumbo') ||
    baseProduct.value?.product_line === 'Jumbo!';
});
const showSizesSelect = computed(() => {
  return availableSizes.value && availableSizes.value.length > 0;
});
const availableSizes = computed(() => {
  // Ellenőrizzük, hogy van-e alaptermék és vannak-e variánsai
  if (!baseProduct.value || !baseProduct.value.productvariants) {
    return [];
  }

  try {
    // Ellenőrizzük, hogy a productvariants tömb-e
    const variants = Array.isArray(baseProduct.value.productvariants)
      ? baseProduct.value.productvariants
      : [baseProduct.value.productvariants];

    // Gyűjtsük ki az egyedi méreteket
    const sizes = new Set(
      variants
        .filter(v => v && v.quantity) // Csak az érvényes variánsokat vesszük figyelembe
        .map(v => v.quantity)
    );

    // Konvertáljuk tömbbé és rendezzük
    return Array.from(sizes).sort((a, b) => a - b);
  } catch (error) {
    console.error('Hiba a méretek feldolgozása során:', error);
    return [];
  }
});

const availableFlavours = computed(() => {
  if (!baseProduct.value?.productvariants || !selectedSize.value) return [];

  // Az aktuális mérethez tartozó ízeket gyűjtjük ki
  return baseProduct.value.productvariants
    .filter(v => v.quantity === Number(selectedSize.value))
    .map(v => v.flavour);
});

const calculatePricePerKg = computed(() => {
  if (!currentVariant.value?.price || !currentVariant.value?.quantity) return 0;
  return Math.round((currentVariant.value.price / currentVariant.value.quantity) * 1000);
});

const handleSizeChange = async () => {
  if (!baseProduct.value || !selectedSize.value) return;

  const variant = baseProduct.value.productvariants.find(
    v => v.quantity === Number(selectedSize.value)
  );

  if (!variant) return;

  selectedFlavour.value = variant.flavour;
  const urlName = baseProduct.value.name === 'Jumbo!' ||
    baseProduct.value.name?.includes('Jumbo')
    ? 'Jumbo!'
    : baseProduct.value.brand.name;

  const newUrl = `/${urlName}-${variant.quantity}${variant.unit}-${variant.flavour}`;
  await router.push(newUrl);
  await loadProduct(urlName, variant.quantity, variant.flavour);
};

const handleFlavourChange = async () => {
  if (!baseProduct.value || !selectedFlavour.value || !selectedSize.value) return;

  const variant = baseProduct.value.productvariants.find(
    v => v.quantity === Number(selectedSize.value) &&
      v.flavour === selectedFlavour.value
  );

  if (!variant) return;

  const urlName = baseProduct.value.name === 'Jumbo!' ||
    baseProduct.value.name?.includes('Jumbo')
    ? 'Jumbo!'
    : baseProduct.value.brand.name;

  const newUrl = `/${urlName}-${variant.quantity}${variant.unit}-${variant.flavour}`;
  await router.push(newUrl);
  await loadProduct(urlName, variant.quantity, variant.flavour);
};

const loadProduct = async (searchName, quantity, flavour) => {
  try {
    isLoading.value = true;

    if (productStore.products.length === 0) {
      await productStore.getProducts();
    }


    // Keressük meg a terméket pontos név egyezéssel először
    let product = productStore.products.find(p => p.name === searchName);
    console.log('első lépés név egyezés: ', product)

    // Ha nincs találat név alapján, próbáljuk brand alapján
    if (!product) {
      product = productStore.products.find(p =>
        p.brand?.name === searchName &&
        p.productvariants?.some(v =>
          String(v.quantity) === String(quantity).replace(/gr|tab/gi, '').trim()
        )
      );
    }


    if (!product) {
      console.error('Nem található termék:', { searchName, quantity });
      isLoading.value = false;
      return;
    }


    // Variáns keresése
    const variant = product.productvariants?.find(v => {
      const quantityMatch = String(v.quantity) === extractNumericQuantity(quantity);
      console.log('adott product quantity-je: ', v.quantity)
      console.log('quantity: ', quantity)
      console.log('van prodtct. quantityMatch: ', quantityMatch)
      const flavourMatch = !flavour || v.flavour?.toLowerCase() === flavour?.toLowerCase();
      return quantityMatch && flavourMatch;
    });


    if (!variant) {
      console.error('Nem található variáns:', { quantity, flavour });
      isLoading.value = false;
      return;
    }


    baseProduct.value = product;
    currentVariant.value = variant;
    selectedFlavour.value = variant.flavour;
    selectedSize.value = variant.quantity;


  } catch (error) {
    console.error('Hiba a termék betöltése során:', error);
  } finally {
    isLoading.value = false;
  }
};

const extractNumericQuantity = (q) => {
  const match = String(q).match(/\d+/);
  return match ? match[0] : '';
};


onMounted(async () => {
  const searchName = route.params.brand;
  const quantity = route.params.quantity;
  const flavour = route.params.flavour;
  await loadProduct(searchName, quantity, flavour);
});
watch(() => currentVariant.value, (newVariant) => {
  if (newVariant && newVariant.quantity) {
    selectedSize.value = newVariant.quantity;
  }
}, { immediate: true });
</script>
