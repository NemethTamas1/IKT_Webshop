<template>
  <BaseHeader />
  <main class="container mx-auto min-h-screen">
    <slot />
  </main>
  <BaseFooter />
</template>


<script setup>
import BaseHeader from '@components/layout/BaseHeader.vue'
import BaseFooter from '@components/layout/BaseFooter.vue'

</script>
