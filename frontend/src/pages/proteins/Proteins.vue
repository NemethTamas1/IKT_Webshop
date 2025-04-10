<template>
    <BaseLayout>
        <div class="mx-auto w-full mb-[250px]">
            <div>
                <p class="text-3xl font-bold text-center my-4" style="font-family:'Nunito'">Fehérjék</p>
                <p class="font-2xl font-semibold text-center" style="font-family:'Nunito'">
                    Kínálatunkban állati és növényi eredetű fehérje készítmények egyaránt széles választékban
                    megtalálhatók.. Céltól, esetleges ételérzékenységtől, vagy egyszerűen ízléstől függően itt biztosan
                    megtalálod, amit keresel!</p>
            </div>

            <div>
                <p class="text-3xl font-bold text-center my-4" style="font-family:'Nunito'">Fehérje készítmények
                    webáruházunkban</p>
                <BaseProductCard :products="productStore.products" />
            </div>
        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from '@layouts/BaseLayout.vue';
import BaseProductCard from '@layouts/BaseProductCard.vue';
import { useProductStore } from '@stores/ProductStore.mjs';
import { onMounted, ref } from 'vue';
import { ToastService } from '@stores/ToastService';

const productStore = useProductStore();
const loading = ref(false);
const error = ref(null);

onMounted(async () => {
    loading.value = true;
    try {
        productStore.getProducts();
    } catch (err) {
        error.value = err.message;
        ToastService.updateToError(toastId, "Hiba a lekérdezéskor!")
    } finally {
        loading.value = false;
    }
});
</script>


<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');
</style>