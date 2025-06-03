<template>
  <BaseLayout>
    <div v-if="cartStore.cart.length === 0">
      <h2 class="text-2xl text-center mt-5">A kosarad üres.</h2>
    </div>

    <div v-else class="grid grid-cols-1 lg:grid-cols-5 gap-6 my-5 mb-40">
      <!-- Kosár tartalma -->
      <div class="col-span-1 lg:col-span-3 bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Kosár tartalma: </h2>
        <div v-for="item in cartStore.cart" :key="item.id" class="border-b py-3 flex justify-between items-center">

          <div>
            <p class="font-semibold">{{ item.name }}</p>
            <p class="text-sm text-gray-500">{{ productStore.formatToOneThousandPrice(item.price) }} Ft × {{
              item.quantity }}</p>
          </div>

          <div class="flex items-center gap-4">
            <p class="font-bold text-sky-600">{{ productStore.formatToOneThousandPrice(item.price * item.quantity) }} Ft
            </p>
            <button @click="cartStore.confirmAndRemoveFromCart(item.id)" class="text-red-500 hover:text-red-700">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>

        </div>
        <p class="text-xl font-bold mt-4">
          Termékek ára összesen: <span class="text-sky-600">{{ productStore.formatToOneThousandPrice(total) }} Ft</span>
        </p>
        <div class="mt-4 w-full h-full xl:flex xl:flex-col xl:justify-center xl:text-center">
          <p class="text-sm italic"><b><u>Tájékoztatás:</u></b> Karbantartási okok miatt a <span
              class="text-lime-700 font-bold">SimplePay&copy</span>-en keresztüli fizetési lehetőség átmenetileg
            <span class="font-bold italic underline underline-offset-2 text-orange-700">szünetel!</span>
          </p>
          <p class="text-sm italic"> Megértésüket és türelmüket köszönjük!</p>
        </div>
      </div>

      <!-- Szállítás -->
      <div ref="szallitasRef" class="lg:col-span-2 bg-white p-4 rounded shadow">
        <p
          class="text-xl mx-auto font-semibold uppercase mb-4 bg-sky-600 text-white w-fit rounded-md px-3 py-1 shadow-md shadow-sky-950/85">
          Szállítási adatok</p>
        <div class="w-11/12 mx-auto rounded-lg border-b-2 border-slate-400/75 mb-4 xl:mb-8"></div>
        <form @submit.prevent="submitOrder">

          <div class="mx-auto w-full grid grid-cols-2 space-x-4 mb-4">
            <!-- Száll. Név -->
            <FormKit v-model="shipping_name" type="text" name="lastname" label="Szállítási név" validation="required"
              label-class="text-sky-600 text-xl" input-class="mt-1 p-2 border border-gray-300 rounded-md w-full"
              placeholder="Kiss András" />
            <!-- Telefonszám -->
            <FormKit v-model="shipping_phone" type="text" name="phone" label="Telefonszám" validation="required"
              label-class="text-sky-600 text-xl" input-class="mt-1 p-2 border border-gray-300 rounded-md w-full"
              placeholder="+36 30 123 4567" />
          </div>

          <!-- Ország kiválasztása -->
          <div class="mx-auto w-full grid grid-cols-2 space-x-4 mb-4">
            <div>
              <label for="orszagValaszto" class="text-sky-600 text-xl pl-1">Ország</label>
              <div @click="toggleDropdownCountry" name="orszagValaszto"
                class="border p-2 mt-1 rounded cursor-pointer bg-white flex justify-between">
                {{ selectedCountry || 'Magyarország' }}
                <i class="fa-solid fa-sort-down text-sky-800 text-xl"></i>
              </div>
              <ul v-if="dropdownOpenCountry"
                class="relative left-0 right-0 bg-white border rounded mt-1 z-50 shadow-lg">
                <li v-for="country in countries" :key="country" @click="selectCountry(country)"
                  class="p-2 hover:bg-sky-100 cursor-pointer">
                  {{ country }}
                </li>
              </ul>
            </div>
            <!-- Város mező -->
            <div>
              <FormKit v-model="shipping_city" type="text" name="city" label="Város" validation="required"
                label-class="text-sky-600 text-xl" input-class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                placeholder="Város" />
            </div>
          </div>

          <!-- Irányítószám és Helység neve -->
          <div class="mx-auto w-full grid grid-cols-2 space-x-4 mb-4">
            <FormKit v-model="shipping_zip" type="text" name="zip" label="Irányítószám" validation="required"
              label-class="text-sky-600 text-xl" input-class="mt-1 p-3 border border-gray-300 rounded-md w-full"
              placeholder="Irányítószám*" />
            <FormKit v-model="shipping_street_name" type="text" name="street_name" label="Helység neve"
              validation="required" label-class="text-sky-600 text-xl"
              input-class="mt-1 p-3 border border-gray-300 rounded-md w-full" placeholder="Akácfa, Alkotás, stb." />
          </div>

          <div class="mx-auto w-full grid grid-cols-2 space-x-4 mb-4">
            <FormKit v-model="shipping_street_type" type="text" name="street_type" label="Helység típusa"
              validation="required" label-class="text-sky-600 text-xl"
              input-class="mt-1 p-3 border border-gray-300 rounded-md w-full" placeholder="út/utca/köz/stb." />
            <FormKit v-model="shipping_street_number" type="text" name="street_number" label="Helység Száma"
              validation="required|number" label-class="text-sky-600 text-xl"
              input-class="mt-1 p-3 border border-gray-300 rounded-md w-full" placeholder="5, 18, 127." />
          </div>
          <FormKit v-model="shipping_floor" type="text" name="floor" label="Emelet, ajtó" validation="required"
            label-class="text-sky-600 text-xl" input-class="mt-1 p-3 border border-gray-300 rounded-md w-full"
            placeholder="1.em 30., félemelet 4., alagsor 22." />

          <!-- Szállítás kiválasztása -->
          <p
            class="text-xl mx-auto font-semibold uppercase mb-4 mt-12 bg-sky-600 text-white w-fit rounded-md px-3 py-1 shadow-md shadow-sky-950/85">
            Fizetési Adatok</p>
          <div class="w-11/12 mx-auto rounded-lg border-b-2 border-slate-400/75 mb-4"></div>
          <div class="mb-4">

            <label for="szallitas" class="text-sky-600 text-xl pl-1">Szállítás</label>
            <div @click="toggleDropdownShipping" name="szallitas"
              class="mt-1 border p-2 rounded cursor-pointer bg-white z-50">
              {{ selectedShippingType || 'Futárszolgálat' }}
            </div>
            <ul v-if="dropdownOpenShipping" class="relative left-0 right-0 bg-white border rounded mt-1 z-10">
              <li v-for="type in shippingTypes" :key="type" @click="selectShippingType(type)"
                class="p-2 hover:bg-sky-100 cursor-pointer">
                {{ type }}
              </li>
            </ul>
          </div>

          <!-- Fizetésmód kiválasztása -->
          <div class="mb-4">
            <label for="fizetesModja" class="text-sky-600 text-xl pl-1 ">Fizetés módja</label>
            <div @click="toggleDropdownPayment" name="fizetesModja"
              class="mt-1 border p-2 rounded cursor-pointer bg-white">
              {{ selectedPaymentMethod || 'Utánvét (fizetés a futárnál)' }}
            </div>
            <ul v-if="dropdownOpenPayment" class="relative left-0 right-0 bg-white border rounded mt-1 z-10">
              <li v-for="method in paymentMethods" :key="method"
                @click="method !== 'SimplePay bankkártyás fizetés' && selectPaymentType(method)"
                class="p-2 hover:bg-sky-100" :class="{
                  'cursor-not-allowed bg-slate-300 opacity-70': method === 'SimplePay bankkártyás fizetés',
                  'cursor-pointer': method !== 'SimplePay bankkártyás fizetés',
                  'hover:bg-sky-100': method !== 'SimplePay bankkártyás fizetés',
                  'hover:bg-slate-300': method === 'SimplePay bankkártyás fizetés'
                }">
                <div class="flex items-center">
                  {{ method }}
                  <span v-if="method === 'SimplePay bankkártyás fizetés'" class="ml-2 text-sm text-red-500">
                    (Átmenetileg nem elérhető)
                  </span>
                </div>
              </li>
            </ul>
          </div>

          <!-- Email cím megadási rész -->
          <div class="mb-4">
            <FormKit v-model="shipping_email" type="email" name="email" label="E-mail cím" validation="required|email"
              label-class="text-sky-600 text-xl pl-1" input-class="mt-1 p-2 border border-gray-300 rounded-md w-full"
              placeholder="E-mail"
              help="Az e-mail címed alapján azonosítunk és erre a címre küldjük a rendeléssel kapcsolatos értesítéseket is."
              help-class="text-gray-500 text-xs italic pt-1 pl-2" />
          </div>

          <div class="w-full mx-auto rounded-lg border-b-4 border-slate-400/75 mt-6 lg:mt-8"></div>

          <div>
            <p class="text-xl font-semibold italic mt-4 mb-1">
              <span class="text-slate-800/75 ">Szállítási díj:</span> <span class="text-sky-600">{{
                productStore.formatToOneThousandPrice(shippingCost) }}
                Ft</span>
            </p>

            <p class="text-xl font-bold">
              Fizetendő összesen: <span class="text-sky-700">{{ productStore.formatToOneThousandPrice(totalWithShipping)
              }} Ft</span>
            </p>
          </div>

          <button type="submit"
            class="mx-auto w-1/2 font-semibold text-lg flex justify-center items-center  bg-sky-600 hover:bg-sky-500 text-white p-2 
          my-6  shadow-lg hover:shadow-lime-900/25 rounded-xl transform transition-all duration-200 border-2 border-lime-600">
            Rendelés véglegesítése
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
import { useProductStore } from '@stores/ProductStore.mjs'
import { computed, ref, onMounted } from 'vue'
import { http } from '@utils/http.mjs';
import { useUserStore } from '@stores/UserStore';

const cartStore = useCartStore();
const userStore = useUserStore();
const productStore = useProductStore();

const dropdownOpenCountry = ref(false);
const dropdownOpenShipping = ref(false);
const dropdownOpenPayment = ref(false);

const szallitasRef = ref(null);
const selectedCountry = ref('');
const selectedShippingType = ref('');
const selectedPaymentMethod = ref('');

const shipping_email = ref('');
const shipping_name = ref('');
const shipping_phone = ref('');
const shipping_city = ref('');
const shipping_zip = ref('');
const shipping_street_name = ref('');
const shipping_street_type = ref('');
const shipping_street_number = ref('');
const shipping_floor = ref('');
const chosenCountry = ref('');
// Order status 'pending' lesz alapból
// totalamount = totalWithShipping
// totalquantity = item.quantity



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

const total = computed(() =>
  cartStore.cart.reduce((sum, item) => sum + item.price * item.quantity, 0)
)

const submitOrder = async (event) => {
  event.preventDefault();
  try {
    const data = {
      shipping_email: shipping_email.value,
      shipping_name: shipping_name.value,
      shipping_phone: shipping_phone.value,
      shipping_country: selectedCountry.value || "Magyarország",
      shipping_city: shipping_city.value,
      shipping_zip: shipping_zip.value.toString(), 
      shipping_street_name: shipping_street_name.value,
      shipping_street_type: shipping_street_type.value,
      shipping_street_number:shipping_street_number.value,
      shipping_floor: shipping_floor.value,
      totalamount: totalWithShipping.value,
      totalquantity: cartStore.totalItems,
    };
    console.log('Küldendő adatok:', data);

    const resp = await http.post('/orders', data);
    if (resp.data) {
      cartStore.clearCart()
    }
  } catch (error) {
    if (error.response) {
      console.error('Validációs hibák vannak:', error.response.data);
    }
    console.error('Hiba a rendelés beküldésekor:', error);
  }
}
onMounted(() => {
  document.addEventListener('click', handleClickAway);
  console.log('Felhasználó:', userStore.userData)
  console.log('cartgenyó: ', userStore.userData.name)

  if(userStore.userData){
    shipping_name.value = userStore.userData.name;
    shipping_phone.value = userStore.userData.phone;
    chosenCountry.value = userStore.userData.country;
    shipping_city.value = userStore.userData.city;
    shipping_zip.value = userStore.userData.zip;
    shipping_street_name.value = userStore.userData.street_name;
    shipping_street_type.value = userStore.userData.street_type;
    shipping_street_number.value = userStore.userData.street_number;
    shipping_floor.value = userStore.userData.floor;
    shipping_email.value = userStore.userData.emai;
  }

})
</script>