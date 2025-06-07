<template>
    <BaseLayout>
        <h1 class="text-4xl mt-5">Saját adataim módosítása</h1>

        <div class="w-8/12">
            <FormKit type="form" :actions="false" @submit="submitForm">
                <FormKit v-model="name" name="name" input-class="w-6/12 p-2 rounded-lg border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="text" label="Teljes név" validation="alpha" />

                <FormKit v-model="email" name="email" input-class="w-6/12 p-2 rounded-lg border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="email" label="Email" validation="email" />

                <FormKit type="text" v-model="phone" label=Telefonszám name="phone"
                    input-class="w-6/12 p-2 rounded-lg border border-gray-500" label-class="text-sky-600 text-2xl" />

                <FormKit v-model="country" name="country" input-class="w-6/12 p-2 rounded-lg border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="text" label="Ország" validation="alpha" />

                <FormKit v-model="city" name="city" input-class="w-6/12 p-2 rounded-lg border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="text" label="Város" validation="alpha" />

                <FormKit v-model="zip" name="zip" input-class="w-6/12 p-2 rounded-lg border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="number" label="Irányítószám" validation="alphanumeric" />

                <FormKit v-model="street_name" name="street_name"
                    input-class="w-6/12 p-2 rounded-lg border border-gray-500" label-class="text-sky-600 text-2xl"
                    type="text" label="Helység neve" validation="alpha" />

                <FormKit v-model="street_type" name="street_type"
                    input-class="w-6/12 p-2 rounded-lg border border-gray-500" label-class="text-sky-600 text-2xl"
                    type="text" label="Helység típusa" validation="alpha" />

                <FormKit v-model="street_number" name="street_number"
                    input-class="w-6/12 p-2 rounded-lg border border-gray-500" label-class="text-sky-600 text-2xl"
                    type="number" label="Helység száma" validation="alphanumeric" />

                <FormKit v-model="floor" name="floor" input-class="w-6/12 p-2 rounded-lg border border-gray-500"
                    label-class="text-sky-600 text-2xl" type="text" label="Emelet / Ajtó" validation="alpha" />

                <button type="submit" class="p-2 rounded-lg bg-sky-600 text-white mt-5">Módosítások mentése</button>
            </FormKit>
        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from '@layouts/BaseLayout.vue';
import { useUserStore } from '@stores/UserStore';
import { onMounted, ref } from 'vue';
import { http } from '@utils/http';

const userStore = useUserStore();

const name = ref('');
const email = ref('');
const country = ref('');
const phone = ref('');
const city = ref('');
const zip = ref('');
const street_name = ref('');
const street_type = ref('');
const street_number = ref('');
const floor = ref('');

const currentUserId = ref(null);

const getUserDataFromId = async (id) => {
    try {
        const response = await http.get(`/users/${id}`);
        const userData = response.data.data;

        phone.value = userData.phone;
        name.value = userData.name;
        email.value = userData.email;
        country.value = userData.country;
        city.value = userData.city;
        zip.value = userData.zip;
        street_name.value = userData.street_name;
        street_type.value = userData.street_type;
        street_number.value = userData.street_number;
        floor.value = userData.floor;



        console.log('response userprofile: ', response.data.data);
    } catch (error) {
        console.error('Hiba a getUserDataFromId közben: ', error)
    }
}

const submitForm = async (formValues) => {
    console.log('Küldendő adatok: ', formValues)
    try {
        const dataToSend = {
            ...formValues
        };
        await userStore.modifyUserData(currentUserId.value, dataToSend);
        alert('Sikeres módosítás!');
    } catch (error) {
        alert('Hiba történt a mentés során!');
    }
};

onMounted(async () => {
    currentUserId.value = await userStore.getUser();
    await getUserDataFromId(currentUserId.value);
})
</script>