<template>
  <BaseLayout>
    <div v-if="cartStore.cart.length === 0">
      <h2 class="text-2xl text-center mt-5">A kosarad üres.</h2>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Kosár tartalma -->
      <div class="md:col-span-2 bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Kosár tartalma: </h2>
        <div v-for="item in cartStore.cart" :key="item.id" class="border-b py-3 flex justify-between items-center">

          <div>
            <p class="font-semibold">{{ item.name }}</p>
            <p class="text-sm text-gray-500">{{ item.price }} Ft × {{ item.quantity }}</p>
          </div>

          <div class="flex items-center gap-4">
            <p class="font-bold text-sky-600">{{ item.price * item.quantity }} Ft</p>
            <button @click="cartStore.confirmAndRemoveFromCart(item.id)" class="text-red-500 hover:text-red-700">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>

        </div>
        <p class="text-xl font-bold mt-4">
          Összesen: <span class="text-sky-600">{{ total }} Ft</span>
        </p>


      </div>

      <!-- Szállítás -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Szállítási információk</h2>
        <form @submit.prevent="submitOrder">
          <input type="text" placeholder="Név" class="w-full mb-3 p-2 border rounded" required />
          <input type="text" placeholder="Cím" class="w-full mb-3 p-2 border rounded" required />
          <input type="tel" placeholder="Telefonszám" class="w-full mb-3 p-2 border rounded" required />
          <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white p-2 rounded mt-2">
            Rendelés leadása
          </button>
        </form>
      </div>
    </div>
  </BaseLayout>
</template>

<script setup>
// Importok
import BaseLayout from '@layouts/BaseLayout.vue'
import { useCartStore } from '@stores/CartStore.js'
import { computed, ref } from 'vue'

// Változók
const cartStore = useCartStore();

const shipping = ref({
  name: '',
  address: '',
  phone: '',
})

// Függvények
const total = computed(() =>
  cartStore.cart.reduce((sum, item) => sum + item.price * item.quantity, 0)
)

function submitOrder() {
  alert(`Rendelés leadva:\nNév: ${shipping.value.name}\nCím: ${shipping.value.address}`)
  cartStore.clearCart()
}
</script>