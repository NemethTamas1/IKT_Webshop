<template>

<div v-if="isMegaDaily" class="w-full mb-40">
    <ScitecMegaDailyOne />
</div>

<div v-else-if="isJumbo" class="w-full mb-40">
    <ScitecJumbo />
</div>

<div v-else-if="brand == 'Scitec'" class="w-full mb-40">
    <ScitecWpp />
</div>

<div v-else-if="brand == 'Builder'" class="w-full mb-40">
    <BuilderWhey />
</div>

<div v-else-if="brand == 'Pro Nutrition'" class="w-full mb-40">
    <ProNutritionProWhey />
</div>

</template>


<script setup>
import ScitecWpp from '@layouts/productdetails/ScitecWpp.vue'
import ScitecJumbo from '@layouts/productdetails/ScitecJumbo.vue'
import BuilderWhey from '@layouts/productdetails/BuilderWhey.vue'
import ProNutritionProWhey from '@layouts/productdetails/ProNutritionProWhey.vue'
import ScitecMegaDailyOne from '@layouts/productdetails/ScitecMegaDailyOne.vue'

const props = defineProps({
    brand: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    },
    product: {
        type: String,
        required: true,
    },
    isJumbo: {
        type: Boolean,
        required: true,
    },
    isMegaDaily: {
        type: Boolean,
        required: true
    }
})

</script>