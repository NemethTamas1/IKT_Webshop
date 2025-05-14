<template>
    <BaseLayout>
        <h1 class="text-3xl font-bold text-center my-10 text-sky-600">
            Belépés / Regisztráció
        </h1>

        <!-- Nagy div -->
        <div class="max-w-screen-md mx-auto grid grid-cols-1">

            <!-- Regisztráció -->
            <div class="border border-gray-300 p-6 rounded-xl shadow-sm">
                <h2 class="text-xl font-semibold text-center text-sky-600 mb-6">Regisztráció</h2>

                <FormKit type="form" :actions="false" class="space-y-6">

                    <!-- Email input -->
                    <div class="my-3">
                        <FormKit type="email" label="E-mail" label-class="text-sky-600 text-xl" placeholder="E-mail *"
                            input-class="p-3 border border-gray-300 rounded-md w-full"
                            help="Az e-mail címed alapján azonosítunk és erre a címre küldjük a rendeléssel kapcsolatos értesítõket."
                            help-class="text-gray-500" />
                    </div>

                    <!-- Vezetnéknév input -->
                    <div class="my-3">
                        <FormKit type="text" label="Vezetéknév" label-class="text-sky-600 text-xl" placeholder="Vezetéknév *"
                            input-class="p-3 border border-gray-300 rounded-md w-full"
                            help="Vezeteknév. A csomagot erre a névre szállítjuk."
                            help-class="text-gray-500" />
                    </div>

                    <!-- Keresztnév input -->
                    <div class="my-3">
                        <FormKit type="text" label="Keresztnév" label-class="text-sky-600 text-xl" placeholder="Keresztnév *"
                            input-class="p-3 border border-gray-300 rounded-md w-full"
                            help="Keresztnév. A csomagot erre a névre szállítjuk."
                            help-class="text-gray-500" />
                    </div>

                    <!-- Jelszó input -->
                    <div class="my-3">
                        <FormKit type="password" label="Jelszó" label-class="text-sky-600 text-xl" placeholder="Jelszó *"
                            input-class="p-3 border border-gray-300 rounded-md w-full"
                            help="Jelszavad. Az itt beírt jelszóval tudsz majd bejelentkezni a rendszerünkbe."
                            help-class="text-gray-500" />
                    </div>

                    <!-- Gomb -->
                    <div class="flex justify-center">
                        <button type="submit"
                            class="px-6 mt-4 py-3 bg-sky-600 text-white rounded-lg font-semibold hover:bg-sky-700 transition">
                            Bejelentkezés
                        </button>
                    </div>
                </FormKit>
            </div>
        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from '@layouts/BaseLayout.vue';
</script>