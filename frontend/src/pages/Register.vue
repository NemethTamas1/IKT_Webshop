<template>
    <BaseLayout>
        <h1 class="text-3xl font-bold text-center my-10 text-sky-600">
            Belépés / Regisztráció
        </h1>

        <div class="mb-40 md:mb-0 max-w-7xl mx-auto grid grid-cols-1">

            <div class="md:border md:border-gray-300 p-6 rounded-xl md:shadow-sm">
                <h2 class="text-xl font-semibold text-center text-sky-600 mb-6">
                    Regisztráció
                </h2>

                <FormKit type="form" :actions="false">
                    <div class="grid md:grid-cols-2 gap-x-6">

                        <!-- Bal oldalon lévő dolgok -->
                        <div class="col-span-1 space-y-4 border-x-2 border-slate-200 px-4 rounded-lg shadow-sm py-4 bg-slate-50">
                            <div class="text-xl font-bold shadow-md bg-slate-300/80 py-3 rounded text-sky-700/90 mb-6"
                                style="font-family: 'Nunito';">
                                <p class="text-center">Személyes adatok</p>
                            </div>
                            <div class="mx-auto w-full grid grid-cols-2 space-x-4">
                                <FormKit type="text" name="lastname" label="Vezetéknév" validation="required"
                                    label-class="text-sky-600 text-xl"
                                    input-class="mt-1 p-3 border border-gray-300 rounded-md w-full"
                                    placeholder="Vezetéknév*" />
                                <FormKit type="text" name="firstname" label="Keresztnév" validation="required"
                                    label-class="text-sky-600 text-xl"
                                    input-class="mt-1 p-3 border border-gray-300 rounded-md w-full"
                                    placeholder="Keresztnév*" />
                            </div>
                            <FormKit type="text" name="phone" label="Telefonszám" validation="required"
                                label-class="text-sky-600 text-xl"
                                input-class="mt-1 p-3 border border-gray-300 rounded-md w-full"
                                placeholder="+36 30 0123 456" />

                            <FormKit type="email" name="email" label="E-mail cím" validation="required|email"
                                label-class="text-sky-600 text-xl pl-1"
                                input-class="mt-1 p-3 border border-gray-300 rounded-md w-full" placeholder="E-mail*"
                                help="Az e-mail címed alapján azonosítunk és erre a címre küldjük a rendeléssel kapcsolatos értesítõket."
                                help-class="text-gray-500 text-xs italic pt-1 pl-2" />

                            <FormKit type="password" name="password" label="Jelszó" validation="required|length:6"
                                label-class="text-sky-600 text-xl"
                                input-class="p-3 border border-gray-300 rounded-md w-full" placeholder="Jelszó*"
                                help="Az itt megadott jelszóval tudsz majd később bejelentkezni a rendszerünkbe."
                                help-class="text-gray-500 text-xs italic pt-1 pl-2" />
                        </div>


                        <!-- Jobb oldalon lévők -->
                        <div class="mt-8 md:mt-0 col-span-1 space-y-4 border-x-2 border-slate-200 px-4 rounded-lg shadow-sm py-4 bg-slate-50">
                            <div class="text-xl font-bold shadow-md bg-slate-300/80 py-3 rounded text-sky-700/90 mb-6"
                                style="font-family: 'Nunito';">
                                <p class="text-center">Szállítási adatok</p>
                            </div>

                            <div class="mx-auto w-full grid grid-cols-2 space-x-4">
                                <FormKit type="text" name="country" label="Ország" validation="required"
                                    label-class="text-sky-600 text-xl"
                                    input-class="mt-1 p-3 border border-gray-300 rounded-md w-full"
                                    placeholder="Ország*" />
                                <FormKit type="text" name="city" label="Város" validation="required"
                                    label-class="text-sky-600 text-xl"
                                    input-class="mt-1 p-3 border border-gray-300 rounded-md w-full"
                                    placeholder="Város" />
                            </div>
                            <div class="mx-auto w-full grid grid-cols-2 space-x-4">
                                <FormKit type="text" name="zip" label="Irányítószám" validation="required|number"
                                    label-class="text-sky-600 text-xl"
                                    input-class="mt-1 p-3 border border-gray-300 rounded-md w-full"
                                    placeholder="Irányítószám*" />
                                <FormKit type="text" name="street_name" label="Helység neve" validation="required"
                                    label-class="text-sky-600 text-xl"
                                    input-class="mt-1 p-3 border border-gray-300 rounded-md w-full"
                                    placeholder="Akácfa, Alkotás, stb." />
                            </div>
                            <div class="mx-auto w-full grid grid-cols-2 space-x-4">
                                <FormKit type="text" name="street_type" label="Helység típusa" validation="required"
                                    label-class="text-sky-600 text-xl"
                                    input-class="mt-1 p-3 border border-gray-300 rounded-md w-full"
                                    placeholder="út, utca, köz stb." />
                                <FormKit type="text" name="street_number" label="Helység Száma" validation="required"
                                    label-class="text-sky-600 text-xl"
                                    input-class="mt-1 p-3 border border-gray-300 rounded-md w-full"
                                    placeholder="5, 18, 127." />
                            </div>
                            <FormKit type="text" name="floor" label="Emelet, ajtó" validation="required"
                                    label-class="text-sky-600 text-xl"
                                    input-class="mt-1 p-3 border border-gray-300 rounded-md w-full"
                                    placeholder="1.em 30., félemelet 4., alagsor 22." />
                        </div>
                    </div>
                    <!-- Submit gomb -->
                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="px-6 py-3 bg-sky-600 text-white rounded-lg font-semibold hover:bg-sky-700 transition">
                            Regisztráció elküldése
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