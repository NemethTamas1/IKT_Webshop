import { defineStore } from "pinia";
import { ref } from "vue";
import { http } from "@utils/http.mjs";

export const useProductStore = defineStore("products", () => {
  const products = ref([]);
  const product = ref(null);
  const productsByBrand = ref([]);
  const filtered = ref([]);

  async function getProducts() {
    const resp = await http.get("/products");
    products.value = resp.data.data;
  }

  async function getProduct(id) {
    const resp = await http.get(`/products/${id}`);
    product.value = resp.data.data;
  }

  // [Elsőnek] >> márkára és elérhetőségre szűrés!
  // [Másodsorban] >> minden termék 1x!
  const sortProductsByBrand = async (brandname) => {
    try {
      const brandFiltered = products.value.filter(
        (product) =>
          product.categories[0].brand === brandname &&
          product.categories[0].available === 1
      );
      filtered.value = brandFiltered.filter((product, index, self) =>
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

  return {
    products,
    product,
    filtered,

    getProducts,
    getProduct,
    sortProductsByBrand,
  };
});
