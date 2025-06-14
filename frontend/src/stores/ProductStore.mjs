import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { http } from "@utils/http.mjs";

export const useProductStore = defineStore("products", () => {
  const products = ref([]);
  const product = ref(null);
  const filtered = ref([]);
  const loading = ref(false);
  const currentProduct = ref(null);
  const currentFlavour = ref(null);
  const selectedFlavour = ref(null);
  const availableFlavours = ref([]);
  const categoryTypes = ref([]);
  const brandTypes = ref([]);

  // Fehérje termékek adatai - előre inicializálva
  const proteinProducts = ref([]);
  const proteinVariants = ref([]);
  const proteinBrands = ref([]);

  // Előre inicializáljuk a stats objektumot, hogy soha ne legyen undefined
  const proteinStats = ref({
    totalProducts: 0,
    totalVariants: 0,
    totalBrands: 0,
  });

  // Kategória kezelések
  const groupedProductsByCategory = ref({});
  const categoriesFetched = ref(false);

  // Alap termék lekérés
  const getProducts = async () => {
    try {
      if (products.value.length > 0) {
        return products.value;
      }
      loading.value = true;
      const resp = await http.get("/products");
      products.value = resp.data.data;
      return products.value;
    } catch (error) {
      console.error("Hiba a termékek lekérése során:", error);
      return [];
    } finally {
      loading.value = false;
    }
  };

  async function getProduct(id) {
    try {
      loading.value = true;
      const resp = await http.get(`/products/${id}`);
      product.value = resp.data.data;
      return resp.data.data
    } catch (error) {
      console.error("Hiba a termék lekérése során:", error);
    } finally {
      loading.value = false;
    }
  }

  const sortProductsByBrand = async (brandName) => {
    try {
      // 1. Brand alapján szűrjük a termékeket
      const brandFiltered = products.value.filter(
        (product) =>
          product.brand?.name?.toLowerCase() === brandName.toLowerCase() &&
          product.available === 1
      );

      // 2. Termékek feldolgozása
      const processedProducts = [];
      const processedItems = new Set();

      brandFiltered.forEach((product) => {
        if (Array.isArray(product.productvariants)) {
          product.productvariants.forEach((variant) => {
            // Egyedi azonosító a termék-mennyiség párhoz
            const itemKey = `${product.name}-${variant.quantity}`;

            if (!processedItems.has(itemKey)) {
              processedItems.add(itemKey);

              processedProducts.push({
                id: `${product.id}-${variant.id}`,
                name: product.name,
                description: product.description || "",
                brand: product.brand,
                category: product.category,
                price: variant.price,
                image_path: variant.image_path || "",
                available: product.available,
                product_line: product.product_line,
                productvariants: {
                  id: variant.id,
                  quantity: variant.quantity,
                  unit: variant.unit,
                  flavour: variant.flavour || null,
                  price: variant.price,
                  available: variant.available,
                },
                // Az összes elérhető variáns ehhez a termékhez és mennyiséghez
                allVariants: product.productvariants
                  .filter((v) => v.quantity === variant.quantity)
                  .map((v) => ({
                    id: v.id,
                    flavour: v.flavour,
                    price: v.price,
                  })),
              });
            }
          });
        } else if (product.productvariants) {
          // Ha csak egy variáns van (pl. tablettás termékek)
          const variant = product.productvariants;
          processedProducts.push({
            id: `${product.id}-${variant.id}`,
            name: product.name,
            description: product.description || "",
            brand: product.brand,
            category: product.category,
            price: variant.price,
            image_path: variant.image_path || "",
            available: product.available,
            product_line: product.product_line,
            productvariants: {
              id: variant.id,
              quantity: variant.quantity,
              unit: variant.unit,
              flavour: null,
              price: variant.price,
              available: variant.available,
            },
          });
        }
      });

      // 3. Rendezés név és mennyiség szerint
      processedProducts.sort((a, b) => {
        // Először név szerint
        const nameCompare = a.name.localeCompare(b.name, "hu", {
          sensitivity: "base",
        });
        if (nameCompare !== 0) return nameCompare;

        // Aztán mennyiség szerint
        const quantityA = parseInt(a.productvariants.quantity);
        const quantityB = parseInt(b.productvariants.quantity);
        return quantityA - quantityB;
      });

      filtered.value = processedProducts;
      return filtered.value;
    } catch (error) {
      console.error("Hiba a szűrésnél:", error);
      throw error;
    }
  };
  // EGYBEN //
  const getFlavoursByDescriptionAndWeight = async (description, quantity) => {
    try {
      const flavours = [];
      products.value.forEach((product) => {
        if (
          product.description === description &&
          product.quantity === quantity
        ) {
          flavours.push(product.flavour);
        }
      });
      return flavours;
    } catch (error) {
      console.error("Hiba az ízesítések lekérése során:", error);
      return [];
    }
  };

  const sortGetOneProduct = async (brandName, quantity, flavour) => {
    try {
      const threeFiltered = [];
      products.value.forEach((product) => {
        const productWeight = Number(product.quantity);
        if (
          product.brand.name.toLowerCase() === brandName.toLowerCase() &&
          productWeight === quantity &&
          product.flavour.toLowerCase() === flavour.toLowerCase()
        ) {
          threeFiltered.push(product);
        }
      });
      return threeFiltered;
    } catch (err) {
      console.error("Hiba a termék lekérdezése során:", err);
      throw err;
    }
  };

  const loadProductDetails = async (brand, quantity, flavour) => {
    try {
      loading.value = true;
      if (!brand || !quantity || !flavour) {
        console.error("loadProductDetails: Hiányzó paraméterek!");
        return;
      }

      const weightNumber = quantity.replace("gr", "");
      const productData = await sortGetOneProduct(
        brand,
        Number(weightNumber),
        flavour
      );

      if (productData?.length > 0) {
        currentProduct.value = productData[0];
        currentFlavour.value = flavour;
        selectedFlavour.value = flavour;

        const flavours = await getFlavoursByDescriptionAndWeight(
          currentProduct.value.description,
          Number(weightNumber)
        );

        availableFlavours.value = flavours;
        if (!availableFlavours.value.includes(flavour)) {
          selectedFlavour.value = flavours[0] || "";
          currentFlavour.value = flavours[0] || "";
        }
      }
    } catch (error) {
      console.error("Hiba a részletek betöltése során:", error);
    } finally {
      loading.value = false;
    }
  };
  // EGYBEN VÉGE //

  const updateSelectedFlavour = (flavour) => {
    try {
      if (!flavour) {
        console.warn("updateSelectedFlavour: Hiányzó ízesítés.");
        return;
      }
      selectedFlavour.value = flavour;
      if (currentProduct.value) {
        currentProduct.value = {
          ...currentProduct.value,
          flavour: flavour,
        };
        currentFlavour.value = flavour;
      }
    } catch (error) {
      console.error("Hiba az ízesítés frissítése során:", error);
    }
  };

  const formatToOneThousandPrice = (price) => {
    try {
      if (!price && price !== 0) return "0";
      const numPrice = Number(price);
      if (isNaN(numPrice)) return "0";
      return numPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    } catch (error) {
      console.error("Hiba az ár formázása során:", error);
      return "0";
    }
  };

  // Alapértelmezett variáns keresése egy adott mérethez
  const getDefaultVariantForSize = (product, size) => {
    if (!product || !product.productvariants || !size) return null;

    return product.productvariants.find((v) => v.quantity === Number(size));
  };

  const getCategories = async () => {
    const response = await http.get('/categories');
    categoryTypes.value = response.data.data;
  };

  const getBrands = async () => {
    const response = await http.get('/brands');
    brandTypes.value = response.data.data;
  };

  const categoryOptions = computed(() => {
    const options = {};
  
    if (Array.isArray(categoryTypes.value)) {
      for (const category of categoryTypes.value) {
        options[category.id] = category.name;
      }
    }
  
    return options;
  });

  const brandOptions = computed(() => {
    const options = {};
  
    if (Array.isArray(brandTypes.value)) {
      for (const brand of brandTypes.value) {
        options[brand.id] = brand.name;
      }
    }
  
    return options;
  });

  const productLines = [
    'wpp',
    'Jumbo!',
    'megadailyone',
    'multiproplus',
    'calciummagnesium',
    'WheyProtein',
    'Cvitamin',
    'vitaday',
    'vitapropack',
    'Pro Whey',
    'dailyhealth',
    'dailyhealth-c-vitamin',
    'dailyhealth-kalcium-magnezium'
  ];

  const productLineOptions = computed(() => {
    return productLines;
  });

  const availabilityOptions = [
    { label: 'Igen', value: 1 },
    { label: 'Nem', value: 0 }
  ];

  const createProduct = async (data) => {
    const response = await http.post('/products', data);
    return response.data.data;
  }

  return {
    // Reaktívok
    products,
    product,
    filtered,
    loading,
    currentProduct,
    selectedFlavour,
    currentFlavour,
    availableFlavours,
    groupedProductsByCategory,
    categoriesFetched,
    proteinProducts,
    proteinVariants,
    proteinBrands,
    proteinStats,
    categoryTypes,
    categoryOptions,
    brandTypes,
    productLines,
    categoryOptions,
    brandOptions,
    productLineOptions,
    availabilityOptions,

    // Alap műveletek
    getProducts,
    getProduct,
    getCategories,
    getBrands,

    // Termék részletek kezelése
    loadProductDetails,
    updateSelectedFlavour,

    // Szűrés és rendezés
    sortProductsByBrand,
    sortGetOneProduct,
    getFlavoursByDescriptionAndWeight,
    getDefaultVariantForSize,
    formatToOneThousandPrice,
    createProduct,
  };
});
