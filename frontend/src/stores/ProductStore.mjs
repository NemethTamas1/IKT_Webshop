import { defineStore } from "pinia";
import { ref } from "vue";
import { http } from "@utils/http.mjs";

export const useProductStore = defineStore("products", () => {
  // Alap termék adatok
  const products = ref([]);
  const oneProduct = ref([]);
  const product = ref(null);
  const filteredProducts = ref();
  const filtered = ref([]);

  // Új perzisztens állapotok
  const currentProduct = ref(null);
  const currentFlavour = ref("");
  const selectedFlavour = ref("");
  const availableFlavours = ref([]);
  const loading = ref(false);

  // Meglévő funkciók
  async function getProducts() {
    try {
      loading.value = true;
      const resp = await http.get("/products");
      products.value = resp.data.data;
    } catch (error) {
      console.error("Hiba a termékek lekérése során:", error);
    } finally {
      loading.value = false;
    }
  }

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

  // Új kiegészítő funkciók
  // Képek útvonalának meghatározása átkerült ide a | brand-weight-flavour komponensből |
  const getImagePath = (brand, weight, flavour, description) => {
    if (!brand || !weight || !flavour) return "/default-image.webp";

    const getProductLine = (brand, description) => {
      if (brand === "Scitec") {
        return description?.includes("Jumbo") ? "Jumbo!" : "wpp";
      }
      const brandLines = { "Pro Nutrition": "Pro Whey", Builder: "WheyProtein" };
      return brandLines[brand] || "";
    };

    const images = import.meta.glob("@/assets/products_img/**/*.webp", { eager: true });
    const subfolder = getProductLine(brand, description);
    const pattern = `products_img/${brand}/${subfolder}/${weight}/${weight}_${flavour}.webp`;

    const key = Object.keys(images).find((path) => path.toLowerCase().includes(pattern.toLowerCase()));
    
    return key ? images[key].default : "/default-image.webp";
  };

  // Egy adott terméknek a részletes betöltése + állapottal kezelése és megőrzése
  // (majd később kosárhoz és az összesítőhöz jó lehet.)
  const loadProductDetails = async (brand, weight, flavour) => {
    try {
      loading.value = true;

      if (!brand || !weight || !flavour) {
        console.error("loadProductDetails: Hiányzó paraméterek!");
        return;
      }

      const weightNumber = weight.toString().replace("gr", "");
      const productData = await sortGetOneProduct(brand, Number(weightNumber), flavour);

      if (productData?.length > 0) {
        currentProduct.value = productData[0]; // Termék adatok frissítése
        currentFlavour.value = flavour; // Aktuális íz frissítése
        selectedFlavour.value = flavour; // Select frissítése

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
    } finally {
      loading.value = false;
    }
  };

  // Amikor az ÍZESÍTÉST megváltoztatja a felh. az "állapotot"
  // frissíteni kell, így nem kell route változtatás.
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


  // F5-ös frissítés után >> az adatok megőrizve maradjanak + ell.
  const restoreStateFromLocalStorage = async () => {
    try {
      loading.value = true;

      const savedProduct = JSON.parse(localStorage.getItem('current-product'));
      const savedFlavour = localStorage.getItem('current-flavour');
      const savedAvailableFlavours = JSON.parse(localStorage.getItem('available-flavours') ?? "[]");

      if (savedProduct) currentProduct.value = savedProduct;
      if (savedFlavour) {
        currentFlavour.value = savedFlavour;
        selectedFlavour.value = savedFlavour; // Frissítjük a select-ben tárolt értéket
      }
      if (Array.isArray(savedAvailableFlavours)) availableFlavours.value = savedAvailableFlavours;

    } catch (error) {
      console.error("Hiba az állapot visszaállítása során:", error);
    } finally {
      loading.value = false;
    }
  };

  // Állapot letárolása/frissítése localStorage-ben!!! automatikusan >> amikor változik.
  const saveStateToLocalStorage = () => {
    try {
      if (currentProduct.value) {
        localStorage.setItem("current-product", JSON.stringify(currentProduct.value));
      }
      if (currentFlavour.value) {
        localStorage.setItem("current-flavour", currentFlavour.value);
      }
      if (availableFlavours.value && availableFlavours.value.length > 0) {
        localStorage.setItem("available-flavours", JSON.stringify(availableFlavours.value));
      }
    } catch (error) {
      console.error("Hiba az állapot mentése során:", error);
    }
  };

  // Watch-ot is használhatnánk, de ez a store szintaxisban nem része a példának
  // Exportált metódusok között célszerű meghívni ezt is frissítéskor
  const sortProductsByBrand = async (brandname) => {
    try {
      const brandFiltered = products.value.filter(
        (product) =>
          product.categories[0].brand === brandname &&
          product.categories[0].available === 1
      );
      filtered.value = brandFiltered.filter(
        (product, index, self) =>
          index === self.findIndex((p) => p.weight === product.weight)
      );
      // Debug
      console.log("Szűrt termékek:", filtered.value);
      return filtered.value;
    } catch (error) {
      console.error("Hiba a szűrésnél:", error);
      throw error;
    }
  };

  const getFlavoursByDescriptionAndWeight = async (description, weight) => {
    try {
      const flavours = [];
      products.value.forEach((product) => {
        if (product.description === description && product.weight === weight) {
          flavours.push(product.flavour);
        }
      });
      return flavours;
    } catch (error) {
      console.error("Hiba az ízesítések lekérése során:", error);
      return [];
    }
  };

  const sortGetOneProduct = async (brandName, weight, flavour) => {
    try {
      const threeFiltered = [];
      products.value.forEach((product) => {
        // Ellenőrizzük és biztosítsuk a megfelelő típusú összehasonlítást
        const productWeight = Number(product.weight); // Konvertálás számra ha szükséges
        if (
          product.categories[0].brand.toLowerCase() ===
            brandName.toLowerCase() &&
          productWeight === weight &&
          product.flavour.toLowerCase() === flavour.toLowerCase()
        ) {
          threeFiltered.push(product);
        }
      });
      return threeFiltered;
    } catch (err) {
      console.error("Hiba a termék lekérdezése során: ", err);
      throw err;
    }
  };

  return {
    // Reaktívok
    products,
    product,
    filteredProducts,
    filtered,
    oneProduct,
    currentProduct,
    selectedFlavour,
    currentFlavour,
    availableFlavours,
    loading,

    // Function-ök
    getProducts,
    getProduct,
    sortProductsByBrand,
    sortGetOneProduct,
    getFlavoursByDescriptionAndWeight,
    getImagePath,
    loadProductDetails,
    updateSelectedFlavour,
    restoreStateFromLocalStorage,
    saveStateToLocalStorage,
  };
});
