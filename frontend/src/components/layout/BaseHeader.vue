<template>
  <nav class="bg-white">
    <div class="flex justify-between p-3 border-b-2 flex-wrap">
      <RouterLink to="/" class="flex items-center space-x-3">
        <span class="self-center text-2xl font-semibold">Buzz<i class="fa-solid fa-bolt text-sky-500"></i>Shop</span>
      </RouterLink>

      <div class="flex justify-between items-center p-3">
        <!--Kosár-->
        <div class="flex items-center space-x-6">
          <button class="block md:hidden text-sky-600">
            <i class="fa-solid fa-basket-shopping text-2xl"></i>
          </button>

          <!-- menü -->
          <button class="block md:hidden text-sky-800" @click="toggleMenu">
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M1 1h15M1 7h15M1 13h15" />
            </svg>
          </button>
        </div>
      </div>

      <div class="w-full md:block md:w-auto bg-sky-50/65 rounded" :class="{ 'hidden': !menuOpen }">
        <ul class="nav-primary flex flex-col p-4 md:flex-row md:p-0 md:space-x-8 md:flex "
          :class="{ 'hidden': !menuOpen }">
          <!-- Mobilon más lesz a nézet!!! -->
          <li
            class="text-lg flex justify-between items-center px-2 text-sky-500 font-medium hover:bg-sky-400 hover:text-white rounded p-2 has-[.active]:font-semibold has-[.active]:hover:text-white">
            <RouterLink to="#" class="flex-grow"><i class="md:fa-solid md:fa-user"></i>Bejelentkezés</RouterLink>
          </li>

          <li class="text-lg relative">
            <div @click="mobileToggleBrands"
              class="text-lg flex justify-between cursor-pointer items-center px-2 text-sky-500 font-medium hover:bg-sky-400 hover:text-white rounded p-2 has-[.active]:font-semibold has-[.active]:hover:text-white">
              <span class="flex-grow font-medium">Minden gyártó</span>
              <i class="fa-solid w-6 text-center " :class="showBrandsMenu ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
            </div>
            <ul v-if="showBrandsMenu"
              class="md:absolute md:top-full md:left-0 md:bg-white md:shadow-lg md:rounded md:py-2 md:w-48 md:z-10 pl-4 md:pl-0 mt-1 ">
              <BaseMobileNavBarDrop :linkText="'/brands'" menuOption="Scitec" />
              <BaseMobileNavBarDrop :linkText="'/brands'" menuOption="Builder" />
              <BaseMobileNavBarDrop :linkText="'/brands'" menuOption="Pro Nutrition" />
            </ul>
          </li>

          <li class="text-lg relative">
            <div @click="mobileToggleTapkieg"
              class="text-lg flex justify-between cursor-pointer items-center p-2 text-sky-500 font-medium hover:text-white hover:bg-sky-400 rounded ">
              <span class="font-medium">Táplálékkiegészítők</span>
              <i class="fa-solid w-6 text-center" :class="showTapkiegMenu ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
            </div>

            <!-- Tápkiegek menüpontjában lévő termékek -->
            <ul v-if="showTapkiegMenu"
              class="no-transform md:absolute md:top-full md:left-0 md:bg-white md:shadow-lg md:rounded md:py-2 md:w-48 md:z-10 pl-4 md:pl-0 mt-1">
              <BaseMobileNavBarDrop linkText="/proteins/Proteins" menuOption="Fehérjék" class="no-transform" />
              <BaseMobileNavBarDrop linkText="/vitamin" menuOption="Multivitaminok" class="no-transform" />
              <BaseMobileNavBarDrop linkText="/vitamin" menuOption="Vitaminok" class="no-transform" />
              <BaseMobileNavBarDrop linkText="/controll-formulas" menuOption="Testsúly-kontroll formulák" class="no-transform" />
            </ul>
          </li>

          <li
            class="text-lg flex justify-between items-center px-2 text-sky-500 font-medium hover:bg-sky-400 hover:text-white rounded p-2 has-[.active]:font-semibold has-[.active]:hover:text-white">
            <RouterLink to="#" class="flex-grow">Sportruházat</RouterLink>
            <i class="fa-solid fa-angle-right w-6 text-center"></i>
          </li>

          <li
            class="text-lg flex justify-between items-center px-2 text-sky-500 font-medium hover:bg-sky-400 hover:text-white rounded p-2 has-[.active]:font-semibold has-[.active]:hover:text-white">
            <RouterLink to="#" class="flex-grow">Kapcsolat</RouterLink>
            <i class="fa-solid fa-angle-right w-6 text-center"></i>
          </li>

          <li
            class="text-lg flex justify-between items-center px-2 text-sky-500 font-medium hover:bg-sky-400 hover:text-white rounded p-2 has-[.active]:font-semibold has-[.active]:hover:text-white">
            <RouterLink to="#" class="flex-grow">Szállítás és fizetés</RouterLink>
            <i class="fa-solid fa-angle-right w-6 text-center"></i>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script setup>
import BaseMobileNavBarDrop from './BaseMobileNavBarDrop.vue';

import { ref } from 'vue'

const menuOpen = ref(false);

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
}
</script>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');

@media (min-width: 768px) {
  .nav-primary > li {
    transition: all 0.3s ease-in-out;
    transform: scale(1.05);
    will-change: transform;
    position: relative;
  }

  .nav-primary > li:hover {
    transform: scale(1.1);
    color: white;
  }
}

@media (max-width: 767px) {
  .nav-primary > li,
  .nav-primary > li:hover,
  .no-transform,
  .no-transform:hover,
  .no-transform > *,
  .no-transform > *:hover {
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