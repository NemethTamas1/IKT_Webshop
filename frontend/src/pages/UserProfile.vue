<template>
    <BaseLayout>
      <div class="max-w-3xl mx-auto py-10">
        <h1 class="text-4xl font-semibold text-sky-700 mb-8 text-center">Saját adataim módosítása</h1>
  
        <FormKit type="form" :actions="false" @submit="submitForm" class="space-y-6">
          <FormKit type="text" name="name" label="Teljes név" v-model="name" input-class="form-input w-6/12 my-3 border border-gray-400 p-2 rounded-lg" label-class="form-label text-2xl text-sky-600" validation="alpha" />
  
          <FormKit type="email" name="email" label="Email" v-model="email" input-class="form-inpu w-6/12 my-3 border border-gray-400 p-2 rounded-lg" label-class="form-label text-2xl text-sky-600" validation="email" />
  
          <FormKit type="text" name="phone" label="Telefonszám" v-model="phone" input-class="form-input w-6/12 my-3 border border-gray-400 p-2 rounded-lg" label-class="form-label text-2xl text-sky-600" />
  
          <FormKit type="text" name="country" label="Ország" v-model="country" input-class="form-input w-6/12 my-3 border border-gray-400 p-2 rounded-lg" label-class="form-label text-2xl text-sky-600" validation="alpha" />
  
          <FormKit type="text" name="city" label="Város" v-model="city" input-class="form-input w-6/12 my-3 border border-gray-400 p-2 rounded-lg" label-class="form-label text-2xl text-sky-600" validation="alpha" />
  
          <FormKit type="number" name="zip" label="Irányítószám" v-model="zip" input-class="form-input w-6/12 my-3 border border-gray-400 p-2 rounded-lg" label-class="form-label text-2xl text-sky-600" validation="alphanumeric" />
  
          <FormKit type="text" name="street_name" label="Helység neve" v-model="street_name" input-class="form-input w-6/12 my-3 border border-gray-400 p-2 rounded-lg" label-class="form-label text-2xl text-sky-600" validation="alpha" />
  
          <FormKit type="text" name="street_type" label="Helység típusa" v-model="street_type" input-class="form-input w-6/12 my-3 border border-gray-400 p-2 rounded-lg" label-class="form-label text-2xl text-sky-600" validation="alpha" />
  
          <FormKit type="number" name="street_number" label="Helység száma" v-model="street_number" input-class="form-input w-6/12 my-3 border border-gray-400 p-2 rounded-lg" label-class="form-label text-2xl text-sky-600" validation="alphanumeric" />
  
          <FormKit type="text" name="floor" label="Emelet / Ajtó" v-model="floor" input-class="form-input w-6/12 my-3 border border-gray-400 p-2 rounded-lg" label-class="form-label text-2xl text-sky-600" validation="alpha" /> 
   
          <div class="text-center">
            <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition">
              Módosítások mentése
            </button>
          </div>
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
    } catch (error) {
        console.error('Hiba a getUserDataFromId közben: ', error)
    }
}

const submitForm = async (formValues) => {
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