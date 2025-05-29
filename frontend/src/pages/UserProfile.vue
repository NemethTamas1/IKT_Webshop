<template>
    <BaseLayout>
        <h1 class="text-4xl mt-5">Saját adataim módosítása</h1>

        <div class="w-8/12">
            <FormKit type="form" :actions="false" @submit="submitForm">
                <FormKit name="vezeteknev" input-class="w-6/12 p-2 rounded-sm border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="text" label="Vezetéknév" validation="alpha" />
                <FormKit name="keresztnev" input-class="w-6/12 p-2 rounded-sm border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="text" label="Keresztnév" validation="alpha" />
                <FormKit name="email" input-class="w-6/12 p-2 rounded-sm border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="email" label="Email" validation="email" />
                <FormKit name="orszag" input-class="w-6/12 p-2 rounded-sm border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="text" label="Ország" validation="alpha" />
                <FormKit name="varos" input-class="w-6/12 p-2 rounded-sm border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="text" label="Város" validation="alpha" />
                <FormKit name="iranyitoszam" input-class="w-6/12 p-2 rounded-sm border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="number" label="Irányítószám" validation="alphanumeric" />
                <FormKit name="helysegNev" input-class="w-6/12 p-2 rounded-sm border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="text" label="Helység neve" validation="alpha" />
                <FormKit name="helysegTipus" input-class="w-6/12 p-2 rounded-sm border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="text" label="Helység típusa" validation="alpha" />
                <FormKit name="helysegSzam" input-class="w-6/12 p-2 rounded-sm border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="number" label="Helység száma" validation="alphanumeric" />
                <FormKit name="emeletAjto" input-class="w-6/12 p-2 rounded-sm border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="text" label="Emelet / Ajtó" validation="alpha" />

                <button type="submit" class="p-2 rounded-lg bg-sky-600 text-white mt-5">Módosítások mentése</button>
            </FormKit>
        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from '@layouts/BaseLayout.vue';
import { useUserStore } from '@stores/UserStore';

const userStore = useUserStore();

const submitForm = async (formValues) => {
    try {
        const dataToSend = {
            ...formValues,
            name: `${formValues.vezeteknev} ${formValues.keresztnev}`.trim(),
        };
        await userStore.modifyUserData(dataToSend);
        alert('Sikeres módosítás!');
    } catch (error) {
        alert('Hiba történt a mentés során!');
    }
};
</script>