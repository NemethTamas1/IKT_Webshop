<template>
  <BaseLayout>
    <div v-if="cartStore.cart.length === 0">
      <h2 class="text-2xl text-center mt-5">A kosarad üres.</h2>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6 my-5">
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
          Termékek ára összesen: <span class="text-sky-600">{{ total }} Ft</span>
        </p>


      </div>

      <!-- Szállítás -->
      <div ref="szallitasRef" class="bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Szállítási és fizetés</h2>
        <form @submit.prevent="submitOrder">

          <!-- Ország kiválasztása -->
          <div class="mb-4">
            <label for="orszagValaszto">Ország</label>
            <div @click="toggleDropdownCountry" name="orszagValaszto"
              class="border p-2 rounded cursor-pointer bg-white">
              {{ selectedCountry || 'Magyarország' }}
            </div>
            <ul v-if="dropdownOpenCountry" class="absolute left-0 right-0 bg-white border rounded mt-1 z-50 shadow-lg">
              <li v-for="country in countries" :key="country" @click="selectCountry(country)"
                class="p-2 hover:bg-sky-100 cursor-pointer">
                {{ country }}
              </li>
            </ul>
          </div>

          <!-- Szállítás kiválasztása -->
          <div class="mb-4">
            <label for="szallitas">Szállítás</label>
            <div @click="toggleDropdownShipping" name="szallitas"
              class="border p-2 rounded cursor-pointer bg-white z-50">
              {{ selectedShippingType || 'Futárszolgálat' }}
            </div>
            <ul v-if="dropdownOpenShipping" class="absolute left-0 right-0 bg-white border rounded mt-1 z-10">
              <li v-for="type in shippingTypes" :key="type" @click="selectShippingType(type)"
                class="p-2 hover:bg-sky-100 cursor-pointer">
                {{ type }}
              </li>
            </ul>
          </div>

          <!-- Fizetésmód kiválasztása -->
          <div class="mb-4">
            <label for="fizetesModja">Fizetés módja</label>
            <div @click="toggleDropdownPayment" name="fizetesModja" class="border p-2 rounded cursor-pointer bg-white">
              {{ selectedPaymentMethod || 'Utánvét (fizetés a futárnál)' }}
            </div>
            <ul v-if="dropdownOpenPayment" class="absolute left-0 right-0 bg-white border rounded mt-1 z-10">
              <li v-for="method in paymentMethods" :key="method" @click="selectPaymentType(method)"
                class="p-2 hover:bg-sky-100 cursor-pointer">
                {{ method }}
              </li>
            </ul>
          </div>

          <div class="mb-4">
            <FormKit type="text" name="Email" label="E-mail" placeholder="E-mail *" validation="required"
              input-class="border border-gray-800 p-2 rounded-lg w-full" />
          </div>



          <p class="text-xl font-bold mt-2">
            Szállítási díj: <span class="text-sky-600">{{ shippingCost }} Ft</span>
          </p>

          <p class="text-xl font-bold mt-2">
            Fizetendő összesen: <span class="text-sky-700">{{ totalWithShipping }} Ft</span>
          </p>

          <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white p-2 rounded mt-2">
            Tovább a rendelésre
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
import { computed, ref, onMounted } from 'vue'

const cartStore = useCartStore()

const dropdownOpenCountry = ref(false);
const dropdownOpenShipping = ref(false);
const dropdownOpenPayment = ref(false);

const szallitasRef = ref(null);
const selectedCountry = ref('');
const selectedShippingType = ref('');
const selectedPaymentMethod = ref('');

const countries = ['Magyarország', 'Németország', 'Ausztria', 'Románia', 'Szlovákia'];
const shippingTypes = ['Futárszolgálat', 'Magyar Posta Logisztikai szállítás', 'FOXPOST'];
const paymentMethods = ['Utánvét (fizetés a futárnál)', 'SimplePay bankkártyás fizetés'];
const shippingPrices = {
  'Magyarország': {
    'Futárszolgálat': 1200,
    'Magyar Posta Logisztikai szállítás': 1400,
    'FOXPOST': 1000,
  },
  'Németország': {
    'Futárszolgálat': 3000,
    'Magyar Posta Logisztikai szállítás': 3200,
    'FOXPOST': 2800,
  },
  'Ausztria': {
    'Futárszolgálat': 3100,
    'Magyar Posta Logisztikai szállítás': 3300,
    'FOXPOST': 2900,
  },
  'Románia': {
    'Futárszolgálat': 2900,
    'Magyar Posta Logisztikai szállítás': 3100,
    'FOXPOST': 2700,
  },
  'Szlovákia': {
    'Futárszolgálat': 2850,
    'Magyar Posta Logisztikai szállítás': 3050,
    'FOXPOST': 2600,
  },
}


const toggleDropdownCountry = () => {
  dropdownOpenCountry.value = !dropdownOpenCountry.value;

  dropdownOpenShipping.value = false;
  dropdownOpenPayment.value = false;
}

const toggleDropdownShipping = () => {
  dropdownOpenShipping.value = !dropdownOpenShipping.value;

  dropdownOpenCountry.value = false;
  dropdownOpenPayment.value = false;
}

const toggleDropdownPayment = () => {
  dropdownOpenPayment.value = !dropdownOpenPayment.value;

  dropdownOpenCountry.value = false;
  dropdownOpenShipping.value = false;
}

const selectCountry = (country) => {
  selectedCountry.value = country
  dropdownOpenCountry.value = false
}

const selectShippingType = (shippingType) => {
  selectedShippingType.value = shippingType
  dropdownOpenShipping.value = false
}

const selectPaymentType = (paymentType) => {
  selectedPaymentMethod.value = paymentType
  dropdownOpenPayment.value = false
}

const handleClickAway = (evt) => {
  if (szallitasRef.value && !szallitasRef.value.contains(evt.target)) {
    dropdownOpenCountry.value = false;
    dropdownOpenShipping.value = false;
    dropdownOpenPayment.value = false;
  }
}

const shippingCost = computed(() => {
  const country = selectedCountry.value || 'Magyarország';
  const shippingType = selectedShippingType.value || 'Futárszolgálat';

  const countryRates = shippingPrices[country];
  if (!countryRates) return 3000;

  return countryRates[shippingType] ?? 3000;
});

const totalWithShipping = computed(() => total.value + shippingCost.value);



const shipping = ref({
  name: '',
  address: '',
  phone: '',
})

const total = computed(() =>
  cartStore.cart.reduce((sum, item) => sum + item.price * item.quantity, 0)
)

function submitOrder() {
  alert(`Rendelés leadva:\nOrszág: ${selectedCountry.value}\nNév: ${shipping.value.name}\nCím: ${shipping.value.address}`)
  cartStore.clearCart()
}

onMounted(() => {
  document.addEventListener('click', handleClickAway);

})
</script>