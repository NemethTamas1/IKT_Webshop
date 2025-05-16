<template>
  <nav class="bg-white">
    <div ref="navMenuRef"
      class="containerw-full mx-auto flex justify-between items-center px-6 h-16 xl:h-20 border-b-2">
      <!-- Logó balra -->
      <RouterLink to="/" class="flex-shrink-0">
        <span class="text-3xl font-semibold">Buzz<i class="fa-solid fa-bolt text-sky-500"></i>Shop</span>
      </RouterLink>

      <!-- Menü + Kosár Container -->
      <div class="flex items-center justify-end flex-grow">
        <RouterLink to="/cart" class="inline-block text-sky-600 hover:text-sky-700 mx-8 relative">
          <i class="fa-solid fa-basket-shopping text-2xl"></i>
          <span class="absolute -top-3 -right-4 bg-amber-500 text-white text-sm font-semibold 
          rounded-full w-5 h-5 flex items-center justify-center">
            {{ cartStore.totalItems }}
          </span>
        </RouterLink>
        <!-- Desktop Menü -->
        <ul class="hidden xl:flex space-x-8 text-lg text-sky-500 font-medium mr-8">
          <li class="hover:text-sky-700">
            <RouterLink to="/login">Bejelentkezés</RouterLink>
          </li>
          <li class="relative group">
            <div @click="toggleDropDown('minden-gyarto')" class="cursor-pointer">
              Minden gyártó
              <i class="fa-solid" :class="showBrandsMenu ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
            </div>
            <ul v-if="activeDropdown === 'minden-gyarto'"
              class="absolute top-full left-0 bg-white shadow-lg rounded py-2 w-48">
              <BaseMobileNavBarDrop :linkText="'/brands/scitec'" menuOption="Scitec" />
              <BaseMobileNavBarDrop :linkText="'/brands/builder'" menuOption="Builder" />
              <BaseMobileNavBarDrop :linkText="'/brands/pronutrition'" menuOption="Pro Nutrition" />
            </ul>
          </li>
          <li class="relative group">
            <div @click="toggleDropDown('taplalekkiegeszitok')" class="cursor-pointer">
              Táplálékkiegészítők
              <i class="fa-solid" :class="showTapkiegMenu ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
            </div>
            <ul v-if="activeDropdown === 'taplalekkiegeszitok'"
              class="absolute top-full left-0 bg-white shadow-lg rounded py-2 w-48">
              <BaseMobileNavBarDrop linkText="/proteins/Proteins" menuOption="Fehérjék" />
              <BaseMobileNavBarDrop linkText="/vitamins/Multivitamins" menuOption="Multivitaminok" />
              <BaseMobileNavBarDrop linkText="/vitamins/Vitamins" menuOption="Vitaminok" />
              <BaseMobileNavBarDrop linkText="/controll-formulas" menuOption="Testsúly-kontroll formulák" />
            </ul>
          </li>
          <li class="hover:text-sky-700">
            <RouterLink to="/clothing">Sportruházat</RouterLink>
          </li>
          <li class="hover:text-sky-700">
            <RouterLink to="/contact">Kapcsolat</RouterLink>
          </li>
          <li class="hover:text-sky-700">
            <RouterLink to="/shipping">Szállítás és fizetés</RouterLink>
          </li>
        </ul>

        <!-- Kosár + Mobil Menü -->
        <div class="flex items-center space-x-4">
          <button class="xl:hidden text-sky-800" @click="toggleMenu">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
    </div>



    <div v-if="menuOpen" class="xl:hidden bg-sky-50/65 rounded">
      <ul class="flex flex-col p-4 space-y-2">
        <!-- Mobilon más lesz a nézet!!! -->

        <!-- Bejelentkezés -->
        <li
          class="text-lg flex justify-between items-center px-2 text-sky-500 font-medium hover:bg-sky-400 hover:text-white rounded p-2 has-[.active]:font-semibold has-[.active]:hover:text-white">
          <RouterLink to="/login" class="flex-grow"><i class="md:fa-solid md:fa-user"></i>Bejelentkezés</RouterLink>
        </li>

        <!-- Minden gyártó -->
        <li class="text-lg relative">
          <div @click="toggleDropDown('minden-gyarto')"
            class="text-lg flex justify-between cursor-pointer items-center px-2 text-sky-500 font-medium hover:bg-sky-400 hover:text-white rounded p-2 has-[.active]:font-semibold has-[.active]:text-white">
            <span class="flex-grow font-medium">Minden gyártó</span>
            <i class="fa-solid w-6 text-center " :class="showBrandsMenu ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
          </div>
          <ul v-if="activeDropdown === 'minden-gyarto'"
            class="md:absolute md:top-full md:left-0 md:bg-white md:shadow-lg md:rounded md:py-2 md:w-48 md:z-10 pl-4 md:pl-0 mt-1 ">
            <BaseMobileNavBarDrop :linkText="'/brands/scitec'" menuOption="Scitec" />
            <BaseMobileNavBarDrop :linkText="'/brands/builder'" menuOption="Builder" />
            <BaseMobileNavBarDrop :linkText="'/brands/pronutrition'" menuOption="Pro Nutrition" />
          </ul>
        </li>

        <!-- Táplálékkiegészítők -->
        <li class="text-lg relative">
          <div @click="toggleDropDown('taplalekkiegeszitok')"
            class="text-lg flex justify-between cursor-pointer items-center p-2 text-sky-500 font-medium hover:text-white hover:bg-sky-400 rounded ">
            <span class="font-medium">Táplálékkiegészítők</span>
            <i class="fa-solid w-6 text-center" :class="showTapkiegMenu ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
          </div>

          <!-- Tápkiegek menüpontjában lévő termékek -->
          <ul v-if="activeDropdown === 'taplalekkiegeszitok'"
            class="no-transform md:absolute md:top-full md:left-0 md:bg-white md:shadow-lg md:rounded md:py-2 md:w-48 md:z-10 pl-4 md:pl-0 mt-1">
            <BaseMobileNavBarDrop linkText="/proteins/Proteins" menuOption="Fehérjék" class="no-transform" />
            <BaseMobileNavBarDrop linkText="/vitamins/Multivitamins" menuOption="Multivitaminok" class="no-transform" />
            <BaseMobileNavBarDrop linkText="/vitamins/Vitamins" menuOption="Vitaminok" class="no-transform" />
            <BaseMobileNavBarDrop linkText="/controll-formulas" menuOption="Testsúly-kontroll formulák"
              class="no-transform" />
          </ul>
        </li>

        <!-- Sportruházat -->
        <li
          class="text-lg flex justify-between items-center px-2 text-sky-500 font-medium hover:bg-sky-400 hover:text-white rounded p-2 has-[.active]:font-semibold has-[.active]:hover:text-white">
          <RouterLink to="#" class="flex-grow">Sportruházat</RouterLink>
        </li>

        <!-- Kapcsolat -->
        <li
          class="text-lg flex justify-between items-center px-2 text-sky-500 font-medium hover:bg-sky-400 hover:text-white rounded p-2 has-[.active]:font-semibold has-[.active]:hover:text-white">
          <RouterLink to="#" class="flex-grow">Kapcsolat</RouterLink>
        </li>

        <!-- Szállítás és fizetés -->
        <li
          class="text-lg flex justify-between items-center px-2 text-sky-500 font-medium hover:bg-sky-400 hover:text-white rounded p-2 has-[.active]:font-semibold has-[.active]:hover:text-white">
          <RouterLink to="#" class="flex-grow">Szállítás és fizetés</RouterLink>
        </li>
      </ul>
    </div>
  </nav>
</template>


<script setup>
import BaseMobileNavBarDrop from './BaseMobileNavBarDrop.vue';
import { useRouter } from 'vue-router';
import { onMounted, ref } from 'vue'
import { useCartStore } from '@stores/CartStore.js'

const cartStore = useCartStore()

const menuOpen = ref(false);
const route = useRouter();
const navMenuRef = ref(null);
const activeDropdown = ref(null);

const toggleDropDown = (type) => {
  if (activeDropdown.value === type) {
    activeDropdown.value = null;
  } else {
    activeDropdown.value = type;
  }
}

const toggleMenu = () => {
  menuOpen.value = !menuOpen.value;
};

// ki-be csukogatás
const showTapkiegMenu = ref(false);
const mobileToggleTapkieg = () => {
  showTapkiegMenu.value = !showTapkiegMenu.value;
}

const showBrandsMenu = ref(false);
const mobileToggleBrands = () => {
  showBrandsMenu.value = !showBrandsMenu.value;
  console.log("showBrandsMenu.value: ", showBrandsMenu.value)
}

//Elkattintáshoz megírt függvény, és a hozzá tartozó eseményfigyelő.
const handleClickAway = (evt) => {
  if (navMenuRef.value && !navMenuRef.value.contains(evt.target)) {
    showBrandsMenu.value = false;
    showTapkiegMenu.value = false;
    menuOpen.value = false;
    activeDropdown.value = false;
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickAway);
  route.afterEach(() => {
    showBrandsMenu.value = false;
    showTapkiegMenu.value = false;
  })
})
</script>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');

@media (min-width: 768px) {
  .nav-primary>li {
    transition: all 0.3s ease-in-out;
    transform: scale(1.05);
    will-change: transform;
    position: relative;
  }

  .nav-primary>li:hover {
    transform: scale(1.1);
    color: white;
  }
}

@media (max-width: 767px) {

  .nav-primary>li,
  .nav-primary>li:hover,
  .no-transform,
  .no-transform:hover,
  .no-transform>*,
  .no-transform>*:hover {
    transform: none !important;
    transition: none !important;
  }
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  min-width: 200px;
  background: white;
}

@media (max-width: 768px) {
  .dropdown-menu {
    position: static;
  }
}

@media (min-width: 768px) {
  .dropdown-menu :deep(li) {
    transition: background-color 0.2s ease-in-out;
  }

  .dropdown-menu :deep(li:hover) {
    background-color: rgb(96 165 250 / 0.1);
  }
}
</style>