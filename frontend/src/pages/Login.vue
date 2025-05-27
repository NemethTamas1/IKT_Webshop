<template>
    <BaseLayout>
        <h1 class="text-3xl font-bold text-center my-10 text-sky-600">
            Belépés / Regisztráció
        </h1>

        <!-- Nagy div -->
        <div class="max-w-screen-lg mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Bejelentkezés -->
            <div class="border border-gray-300 p-6 rounded-xl shadow-sm">
                <h2 class="text-xl font-semibold text-center text-sky-600 mb-6">
                    Belépés
                </h2>

                <FormKit type="form" :actions="false" @submit="handleLogin" class="space-y-6">

                    <!-- Email input -->
                    <div class="my-2">
                        <FormKit v-model="email" type="email" label="E-mail" label-class="text-sky-600 text-xl" placeholder="E-mail"
                            input-class="p-3 border border-gray-300 rounded-md w-full" />
                    </div>

                    <!-- Jelszó input -->
                    <div class="my-2">
                        <FormKit v-model="password" type="password" label="Jelszó" label-class="text-sky-600 text-xl" placeholder="Jelszó"
                            input-class="p-3 border border-gray-300 rounded-md w-full" />
                    </div>

                    <!-- Gomb -->
                    <div class="flex justify-center">
                        <button type="submit"
                            class="px-6 my-3 py-2 bg-sky-600 text-white rounded-lg font-semibold hover:bg-sky-700 transition">
                            Bejelentkezés
                        </button>
                    </div>
                </FormKit>
            </div>

            <!-- Regisztráció -->
            <div class="border p-6 rounded-xl border-gray-300 shadow-sm flex flex-col justify-center text-center">
                <h2 class="text-xl font-semibold text-sky-600 mb-4">
                    Regisztráció
                </h2>

                <p class="mb-8 text-gray-700">
                    Nincs még BuzzShop Webáruház regisztrációd?<br />
                    Kattints az alábbi gombra és regisztrálj!
                </p>

                <div class="flex justify-center">
                    <RouterLink to="/register">
                        <button type="button"
                            class="px-6 py-2 bg-sky-600 text-white rounded-lg font-semibold hover:bg-sky-700 transition">
                            Regisztráció
                        </button>
                    </RouterLink>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from '@layouts/BaseLayout.vue';
import { useUserStore } from '@stores/UserStore';
import { ref } from 'vue';
import { ToastService } from '@stores/ToastService';
import { useRouter } from 'vue-router';
 
const userStore = useUserStore();

const email = ref('');
const password = ref('');
const router = useRouter();

const handleLogin = async () => {
    console.log('email: ', email.value);
    console.log('password: ', password.value);

    await userStore.authenticateUser(email.value, password.value);
    router.push('/')
    ToastService.showSuccess(`${email.value} sikeresen bejelentkezett!`)
};
</script>