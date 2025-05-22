<template>
  <nav class="bg-white">
    <div ref="navMenuRef" class="w-full mx-auto flex justify-between items-center px-6 h-16 xl:h-20 border-b-2">
      <!-- Logo -->
      <RouterLink to="/" class="flex-shrink-0">
        <span class="text-3xl font-semibold">
          Buzz<i class="fa-solid fa-bolt text-sky-500"></i>Shop
        </span>
      </RouterLink>

      <!-- Menu + Cart -->
      <div class="flex items-center justify-end flex-grow">
        <RouterLink to="/cart" class="inline-block text-sky-600 hover:text-sky-700 mx-8 relative">
          <i class="fa-solid fa-basket-shopping text-2xl"></i>
          <span
            class="absolute -top-3 -right-4 bg-amber-500 text-white text-sm font-semibold rounded-full w-5 h-5 flex items-center justify-center">
            {{ cartStore.totalItems }}
          </span>
        </RouterLink>

        <!-- Desktop Menu -->
        <ul class="hidden xl:flex space-x-8 text-lg text-sky-500 font-medium mr-8">
          <li class="hover:text-sky-700">
            <RouterLink v-if="!isUserLoggedIn" to="/login">Bejelentkezés</RouterLink>
            <button v-if="isUserLoggedIn" @click="handleLogOut">Kijelentkezés</button>
          </li>
          <li class="relative">
            <div @click="toggleDropdown('minden-gyarto')" class="cursor-pointer hover:text-sky-700">
              Minden gyártó
              <i class="fa-solid"
                :class="activeDropdown === 'minden-gyarto' ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
            </div>
            <ul v-if="activeDropdown === 'minden-gyarto'"
              class="absolute top-full left-0 bg-white shadow-lg rounded py-2 w-48">
              <BaseMobileNavBarDrop linkText="/brands/scitec" menuOption="Scitec" />
              <BaseMobileNavBarDrop linkText="/brands/builder" menuOption="Builder" />
              <BaseMobileNavBarDrop linkText="/brands/pronutrition" menuOption="Pro Nutrition" />
            </ul>
          </li>
          <li class="relative">
            <div @click="toggleDropdown('taplalekkiegeszitok')" class="cursor-pointer hover:text-sky-700">
              Táplálékkiegészítők
              <i class="fa-solid"
                :class="activeDropdown === 'taplalekkiegeszitok' ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
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

        <!-- Mobile Menu Icon -->
        <button class="xl:hidden text-sky-800" @click="toggleMenu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div v-if="menuOpen" class="xl:hidden bg-sky-50/65 rounded">
      <ul class="flex flex-col p-4 space-y-2">
        <li class="text-lg px-2 hover:bg-sky-400 hover:text-white rounded p-2 text-sky-500 font-medium">
          <RouterLink to="/login">Bejelentkezés</RouterLink>
        </li>

        <!-- Dropdown: Minden Gyártó -->
        <li class="text-lg relative">
          <div @click.stop="toggleDropdown('minden-gyarto')"
            class="flex justify-between px-2 text-sky-500 font-medium hover:bg-sky-400 hover:text-white rounded p-2">
            <span>Minden gyártó</span>
            <i class="fa-solid w-6"
              :class="activeDropdown === 'minden-gyarto' ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
          </div>
          <ul v-if="activeDropdown === 'minden-gyarto'" class="pl-4 space-y-2">
            <BaseMobileNavBarDrop linkText="/brands/scitec" menuOption="Scitec" />
            <BaseMobileNavBarDrop linkText="/brands/builder" menuOption="Builder" />
            <BaseMobileNavBarDrop linkText="/brands/pronutrition" menuOption="Pro Nutrition" />
          </ul>
        </li>

        <!-- Dropdown: Táplálékkiegészítők -->
        <li class="text-lg relative">
          <div @click.stop="toggleDropdown('taplalekkiegeszitok')"
            class="flex justify-between px-2 text-sky-500 font-medium hover:bg-sky-400 hover:text-white rounded p-2">
            <span>Táplálékkiegészítők</span>
            <i class="fa-solid w-6"
              :class="activeDropdown === 'taplalekkiegeszitok' ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
          </div>
          <ul v-if="activeDropdown === 'taplalekkiegeszitok'" class="pl-4 space-y-2">
            <BaseMobileNavBarDrop linkText="/proteins/Proteins" menuOption="Fehérjék" />
            <BaseMobileNavBarDrop linkText="/vitamins/Multivitamins" menuOption="Multivitaminok" />
            <BaseMobileNavBarDrop linkText="/vitamins/Vitamins" menuOption="Vitaminok" />
            <BaseMobileNavBarDrop linkText="/controll-formulas" menuOption="Testsúly-kontroll formulák" />
          </ul>
        </li>

        <li class="text-lg px-2 hover:bg-sky-400 hover:text-white rounded p-2 text-sky-500 font-medium">
          <RouterLink to="/clothing">Sportruházat</RouterLink>
        </li>
        <li class="text-lg px-2 hover:bg-sky-400 hover:text-white rounded p-2 text-sky-500 font-medium">
          <RouterLink to="/contact">Kapcsolat</RouterLink>
        </li>
        <li class="text-lg px-2 hover:bg-sky-400 hover:text-white rounded p-2 text-sky-500 font-medium">
          <RouterLink to="/shipping">Szállítás és fizetés</RouterLink>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script setup>
import BaseMobileNavBarDrop from './BaseMobileNavBarDrop.vue';
import { ref, onMounted } from 'vue';
import { useCartStore } from '@stores/CartStore';
import {router} from '@/router/index.js';
import { useUserStore } from '@stores/UserStore';
import { ToastService } from '@stores/ToastService';

const cartStore = useCartStore();
const userStore = useUserStore();

const menuOpen = ref(false);
const activeDropdown = ref(null);
const navMenuRef = ref(null);

const toggleMenu = () => {
  menuOpen.value = !menuOpen.value;
};

const isUserLoggedIn = ref(null);

const toggleDropdown = (dropdownType) => {
  if (activeDropdown.value === dropdownType) {
    activeDropdown.value = null;
  } else {
    activeDropdown.value = dropdownType;
  }
};

const handleLogOut = async () => {
  await userStore.logout();
  isUserLoggedIn.value = false;

  ToastService.showSuccess('A felhasználó kijelentkezett!')
};

const handleClickAway = (e) => {
  if (!navMenuRef?.value?.contains(e.target)) {
    menuOpen.value = false;
    activeDropdown.value = null;
  }
};


onMounted(async() => {
  isUserLoggedIn.value = await userStore.isLoggedIn();

  document.addEventListener('click', handleClickAway);

  router.afterEach(()=>{
    activeDropdown.value = null;
    menuOpen.value = false;
  });
});



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
  .no-transform:hover {
    transform: none !important;
    transition: none !important;
  }
}
</style>
