import { defineStore } from "pinia";
import { ref } from "vue";
import { http } from "@utils/http.mjs";

export const useProductStore = defineStore("products", () => {
  const products = ref([]);
  const product = ref(null);
  const productsByBrand = ref([]);

  async function getProducts() {
    const resp = await http.get("/products");
    products.value = resp.data.data;
  }

  async function getProduct(id) {
    const resp = await http.get(`/products/${id}`);
    product.value = resp.data.data;
  }

  // márkára és elérhetőségre szűrés!
  const sortProductsByBrand = async (brandname) => {
    const filtered = products.value.filter(
      (product) =>
        product.categories.brand === brandname &&
        product.categories.avaliable === 1
    );
    productsByBrand.value = filtered;
    return filtered;
  };

  return {
    products,
    product,
    productsByBrand,

    getProducts,
    getProduct,
    sortProductsByBrand,
  };
});
