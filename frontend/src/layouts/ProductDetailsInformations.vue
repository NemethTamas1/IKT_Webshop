<template>
    <div v-if="brand == 'Scitec'" class="w-4/5 mb-40">
        <div v-if="description=='Jumbo!'"> 
            <ScitecJumbo/>
        </div>
        <div v-else>
            <ScitecWpp />
        </div>
    </div>
    <div v-else-if="brand == 'Builder'"  class="w-4/5 mb-40">
        <BuilderWhey />
    </div>

    <div v-else-if="brand == 'Pro Nutrition'" class="w-4/5 mb-40">
       <ProNutritionProWhey/>
    </div>

    <div v-else>
        betöltés...
    </div>
</template>


<script setup>
import ScitecWpp from '@layouts/productdetails/ScitecWpp.vue'
import ScitecJumbo from '@layouts/productdetails/ScitecJumbo.vue'
import BuilderWhey from '@layouts/productdetails/BuilderWhey.vue'
import ProNutritionProWhey from '@layouts/productdetails/ProNutritionProWhey.vue'

const props = defineProps({
    brand: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    }
})
</script>