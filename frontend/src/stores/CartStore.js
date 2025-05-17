import { defineStore } from "pinia";
import { ref, computed } from "vue";
import { http } from "@utils/http.mjs";
import { ToastService } from "@stores/ToastService.js";

export const useCartStore = defineStore("cart", () => {
  // Változók
  const storedCart = JSON.parse(localStorage.getItem('cartItems') || '[]');
  const cart = ref(storedCart);

  // Függvények
  const addToCart = (product) => {
    const existing = cart.value.find((item) => item.id === product.id);

    if (existing) {
      existing.quantity += 1;
    } else {
      cart.value.push({ ...product, quantity: 1 });
    }

    saveCartToLocalStorage();
  };

  // Hogy f5 után ne ürüljön a kosár..
  const saveCartToLocalStorage = () => {
    localStorage.setItem('cartItems', JSON.stringify(cart.value));
  };

  const confirmAndRemoveFromCart = (productId) => {
    const confirmed = window.confirm(
      "Biztosan ki szeretnéd törölni ezt a terméket?"
    );

    if (!confirmed) return;

    cart.value = cart.value.filter((item) => item.id !== productId);
    ToastService.showSuccess("Termék eltávolítva a kosárból.");
    saveCartToLocalStorage();
  };

  const clearCart = () => {
    cart.value = [];
    saveCartToLocalStorage();
  };

  const totalItems = computed(() => {
    return cart.value.reduce((sum, item) => sum + item.quantity, 0);
  });

  // EZT MÓDOSÍTOTTAM A FENTIRE! [!!!]

  // const totalItems = () => {
  //     cart.value.reduce((sum, item) => sum + item.quantity, 0);
  // }

  // Visszatérési értékek
  return {
    cart,
    addToCart,
    confirmAndRemoveFromCart,
    clearCart,
    totalItems,
  };
});
