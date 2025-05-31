<style>
@import url('https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Monoton&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Permanent+Marker&family=Rasa:ital,wght@0,300..700;1,300..700&family=Tourney:wght@100..900&display=swap');
</style>

<script>
import { onMounted } from 'vue';
onMounted(async () => {
  await productStore.getProducts();
});
</script>

<template>
  <RouterView />
</template>
