import { defineStore } from "pinia";
import { ref } from "vue";
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
  const filteredProteinVariants = ref([]);

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
    } catch (error) {
      console.error("Hiba a termék lekérése során:", error);
    } finally {
      loading.value = false;
    }
  }

  const getAllProteinProducts = () => {
    return products.value.filter(
      (product) =>
        product.available === 1 &&
        // Kategória név alapján
        ((product.category && product.category.name === "protein") ||
          // Vagy kategória leírás alapján
          (product.category &&
            product.category.description &&
            (product.category.description.toLowerCase().includes("fehérje") ||
              product.category.description
                .toLowerCase()
                .includes("protein"))) ||
          // Vagy terméknév alapján
          (product.name &&
            (product.name.toLowerCase().includes("fehérje") ||
              product.name.toLowerCase().includes("protein"))) ||
          // Vagy termék leírás alapján
          (product.description &&
            (product.description.toLowerCase().includes("fehérje") ||
              product.description.toLowerCase().includes("protein"))) ||
          // Vagy product_line alapján
          (product.product_line &&
            (product.product_line.toLowerCase().includes("protein") ||
              product.product_line.toLowerCase().includes("whey"))))
    );
  };
  const updateProteinStats = () => {
    proteinStats.value = {
      totalProducts: proteinProducts.value.length,
      totalVariants: proteinVariants.value.length,
      totalBrands: proteinBrands.value.length,
    };
  };

  // Csoportosítás a kategória leírás alapján
  const groupProteinProductsByCategory = () => {
    const grouped = {};

    proteinProducts.value.forEach((product) => {
      // Az alkategória a leírásban lehet, ha nincs, használjuk a "Egyéb" kategóriát
      const categoryName =
        product.category && product.category.description
          ? product.category.description
          : "Egyéb fehérjék";

      if (!grouped[categoryName]) {
        grouped[categoryName] = [];
      }

      grouped[categoryName].push(product);
    });

    return grouped;
  };
  // Termékek csoportosítása kategória szerint
  const groupProductsByCategory = (products, filterByProtein = false) => {
    const grouped = {};
    const productsToGroup = filterByProtein
      ? products.filter((p) => p.category?.name === "protein")
      : products;

    productsToGroup.forEach((product) => {
      if (product.category && product.category.description) {
        const categoryDesc = product.category.description;
        if (!grouped[categoryDesc]) {
          grouped[categoryDesc] = [];
        }
        grouped[categoryDesc].push(product);
      }
    });

    return grouped;
  };

  // Képek útvonalának meghatározása
  const getImagePath = (brand, quantity, flavour, description, productLine) => {
    try {
      if (!brand || !quantity || !flavour) {
        console.warn("Hiányzó adatok a kép elérési útjához:", {
          brand,
          quantity,
          flavour,
        });
        return "";
      }

      const getProductLine = (brand, description, productLine) => {
        if (productLine === "Jumbo!") {
          return "Jumbo!";
        }
        if (brand === "Scitec") {
          return description?.includes("Jumbo") ? "Jumbo!" : "wpp";
        }
        const brandLines = {
          ProNutrition: "ProWhey",
          Builder: "WheyProtein",
        };
        return brandLines[brand] || "";
      };

      const images = import.meta.glob("@/assets/products_img/**/*.webp", {
        eager: true,
      });

      const subfolder = getProductLine(brand, description, productLine);
      const pattern = `products_img/${brand}/${subfolder}/${quantity}/${quantity}_${flavour}.webp`;

      for (const path in images) {
        if (path.includes(pattern)) {
          return images[path].default;
        }
      }
    } catch (error) {
      console.error("Hiba a kép betöltése során:", error);
      return "";
    }
  };

  const sortProductsByBrand = async (brandName) => {
    try {
      const brandFiltered = products.value.filter(
        (product) =>
          product.brand &&
          product.brand.name &&
          product.brand.name.toLowerCase() === brandName.toLowerCase() &&
          product.available === 1
      );

      const weightGroups = {};

      brandFiltered.forEach((product) => {
        if (product.productvariants && product.productvariants.length > 0) {
          if (Array.isArray(product.productvariants)) {
            product.productvariants.forEach((variant) => {
              if (variant.quantity !== undefined && variant.quantity !== null) {
                const quantityKey = String(variant.quantity);
                if (!weightGroups[quantityKey]) {
                  weightGroups[quantityKey] = {
                    id: product.id,
                    variant_id: variant.id,
                    name: product.name,
                    description: product.description || "",
                    quantity: variant.quantity,
                    price: variant.price,
                    image_path: variant.image_path || "",
                    brand: product.brand,
                    available: product.available,
                    category: product.category,
                    flavour: variant.flavour || "",
                    productvariants: variant,
                  };
                }
              }
            });
          }
        }
      });

      filtered.value = Object.values(weightGroups);
      return filtered.value;
    } catch (error) {
      console.error("Hiba a szűrésnél:", error);
      throw error;
    }
  };

  const sortProductsByBrandToCategoryGroupMenu = async (brandName) => {
    try {
      const brandFiltered = products.value.filter(
        (product) =>
          product.brand &&
          product.brand.name &&
          product.brand.name.toLowerCase() === brandName.toLowerCase() &&
          product.available === 1 &&
          product.category.name === "protein"
      );
      filtered.value = sortGetUniqueByQuantity(brandFiltered);
      return filtered.value;
    } catch (error) {
      console.error("Hiba a szűrésnél:", error);
      throw error;
    }
  };

  // ÚJ: Termékek csoportosítása kategória szerint
  async function getProductsByCategories() {
    if (
      categoriesFetched.value &&
      Object.keys(groupedProductsByCategory.value).length > 0
    ) {
      return groupedProductsByCategory.value;
    }

    try {
      loading.value = true;
      if (products.value.length === 0) {
        await getProducts();
      }

      groupedProductsByCategory.value = groupProductsByCategory(products.value);
      categoriesFetched.value = true;
      return groupedProductsByCategory.value;
    } catch (error) {
      console.error("Hiba a kategóriák szerinti csoportosítás során:", error);
      return {};
    } finally {
      loading.value = false;
    }
  }

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
  // Storage kezelés
  const STORAGE_KEYS = {
    PRODUCT: "current-product",
    FLAVOUR: "current-flavour",
    AVAILABLE_FLAVOURS: "available-flavours",
  };

  const saveStateToLocalStorage = () => {
    try {
      if (currentProduct.value) {
        localStorage.setItem(
          STORAGE_KEYS.PRODUCT,
          JSON.stringify(currentProduct.value)
        );
      }
      if (currentFlavour.value) {
        localStorage.setItem(STORAGE_KEYS.FLAVOUR, currentFlavour.value);
      }
      if (availableFlavours.value && availableFlavours.value.length > 0) {
        localStorage.setItem(
          STORAGE_KEYS.AVAILABLE_FLAVOURS,
          JSON.stringify(availableFlavours.value)
        );
      }
    } catch (error) {
      console.error("Hiba az állapot mentése során:", error);
    }
  };

  const restoreStateFromLocalStorage = async () => {
    try {
      loading.value = true;
      const savedProduct = JSON.parse(
        localStorage.getItem(STORAGE_KEYS.PRODUCT)
      );
      const savedFlavour = localStorage.getItem(STORAGE_KEYS.FLAVOUR);
      const savedAvailableFlavours = JSON.parse(
        localStorage.getItem(STORAGE_KEYS.AVAILABLE_FLAVOURS)
      );

      if (savedProduct) currentProduct.value = savedProduct;
      if (savedFlavour) {
        currentFlavour.value = savedFlavour;
        selectedFlavour.value = savedFlavour;
      }
      if (Array.isArray(savedAvailableFlavours))
        availableFlavours.value = savedAvailableFlavours;
    } catch (error) {
      console.error("Hiba az állapot visszaállítása során:", error);
    } finally {
      loading.value = false;
    }
  };

  const extractProteinBrands = () => {
    const brandsMap = new Map();
    proteinProducts.value.forEach((product) => {
      if (product.brand && product.brand.id && product.brand.name) {
        brandsMap.set(product.brand.id, {
          id: product.brand.id,
          name: product.brand.name,
          description: product.brand.description || "",
          image_path: product.brand.image_path || "",
        });
      }
    });
    proteinBrands.value = Array.from(brandsMap.values());
    return proteinBrands.value;
  };

  const formatToOneThousandPrice = (price) => {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
  };

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

    // Alap műveletek
    getProducts,
    getProduct,
    getImagePath,

    // Protein specifikus műveletek
    getAllProteinProducts,
    extractProteinBrands,

    // Termék részletek kezelése
    loadProductDetails,
    updateSelectedFlavour,

    // Szűrés és rendezés
    sortProductsByBrand,
    sortGetOneProduct,
    getFlavoursByDescriptionAndWeight,

    // Kategória kezelés
    getProductsByCategories,
    groupProductsByCategory,

    // Storage kezelés
    saveStateToLocalStorage,
    restoreStateFromLocalStorage,

    sortProductsByBrandToCategoryGroupMenu,
    updateProteinStats,
    groupProteinProductsByCategory,
    extractProteinBrands,
    formatToOneThousandPrice,
  };
});
