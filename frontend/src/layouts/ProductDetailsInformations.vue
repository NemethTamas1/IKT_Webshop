<template>
    <div class="w-full mb-40 px-12">
        <!-- Vitaminok & Multivitaminokat itt kezeljük (átadott értékek alapján) -->
        <ScitecMegaDailyOne v-if="isMegaDaily && categoryName === 'multivitamin'" />
        <BuilderVitaDay v-else-if="isVitaDay && categoryName === 'multivitamin'" />
        <BuilderCVitamin v-else-if="isBuilderCvitamin && categoryName === 'vitamin'" />
        <BuilderVitaproPack v-else-if="isVitaproPack && categoryName === 'multivitamin'" />
        <ScitecMultiProPlus v-else-if="isMultiProPlus && categoryName === 'multivitamin'" />
        <ProNutritionDailyHealth v-else-if="isProNutritionDailyHealthComplex && categoryName === 'multivitamin'" />
        <ProNutritionKalcMagn v-else-if="isDailyHealthKalciumMagnezium && categoryName === 'vitamin'" />
        <ProNutritionDailyHealthCVitamin v-else-if="isProNutritionDailyHealthCVitamin && categoryName === 'vitamin'" />
        <ScitecCalciumMagnesium v-else-if="isScitecCalciumMagnesium && categoryName === 'vitamin'" />

        <!-- Protein-eknél szintúgy ugyanez -->
        <ScitecJumbo v-else-if="isJumbo" />
        <template v-else>
            <ScitecWpp v-if="brand === 'Scitec' && categoryName === 'protein'" />
            <BuilderWhey v-else-if="brand === 'Builder' && categoryName === 'protein'" />
            <ProNutritionProWhey v-else-if="brand === 'Pro Nutrition' && categoryName === 'protein'" />
        </template>
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
import ScitecMultiProPlus from '@layouts/productdetails/ScitecMultiProPlus.vue'
import BuilderCVitamin from '@layouts/productdetails/BuilderCVitamin.vue'
import ProNutritionKalcMagn from '@layouts/productdetails/ProNutritionKalcMagn.vue'
import ProNutritionDailyHealthCVitamin from '@layouts/productdetails/ProNutritionDailyHealthCVitamin.vue'
import ScitecCalciumMagnesium from '@layouts/productdetails/ScitecCalciumMagnesium.vue'

const props = defineProps({
    brand: {
        type: String,
        required: true
    },
    product: {
        type: String,
        required: true
    },
    description: {
        type: String,
        default: ''
    },
    isJumbo: {
        type: Boolean,
        default: false
    },
    isMegaDaily: {
        type: Boolean,
        default: false
    },
    isVitaDay: {
        type: Boolean,
        default: false
    },
    isVitaproPack: {
        type: Boolean,
        default: false
    },
    isBuilderCvitamin: {
        type: Boolean,
        default: false
    },
    isMultiProPlus: {
        type: Boolean,
        default: false
    },
    isProNutritionDailyHealthComplex: {
        type: Boolean,
        default: false
    },
    isDailyHealthKalciumMagnezium: {
        type: Boolean,
        required: true
    },
    isProNutritionDailyHealthCVitamin: {
        type: Boolean,
        required: true
    },
    categoryName: {
        type: String,
        required: true
    },
    isScitecCalciumMagnesium: {
        type: Boolean,
        required: true
    } 
});
</script>