<template>

<div v-if="isMegaDaily" class="w-full mb-40">
    <ScitecMegaDailyOne />
</div>

<div v-else-if="isVitaDay" class="w-full mb-40">
    <BuilderVitaDay />
</div>

<div v-else-if="isVitaproPack" class="w-full mb-40">
    <BuilderVitaproPack />
</div>

<div v-else-if="ProNutritionDailyHealth" class="w-full mb-40">
    <ProNutritionDailyHealth />
</div>

<div v-else-if="isMultiProPlus" class="w-full mb-40">
    
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
import BuilderVitaDay from '@layouts/productdetails/BuilderVitaDay.vue'
import BuilderVitaproPack from '@layouts/productdetails/BuilderVitaproPack.vue'
import ProNutritionDailyHealth from '@layouts/productdetails/ProNutritionDailyHealth.vue'

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
    },
    isVitaDay: {
        type: Boolean,
        required: true
    },
    isVitaproPack: {
        type: Boolean,
        required: true
    },
    isMultiProPlus: {
        type: Boolean,
        required: true
    },
    isProNutritionDailyHealthComplex: {
        type: Boolean,
        required: true
    }
})

</script>