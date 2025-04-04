<template>
     <div class="mx-auto mt-12 px-6 w-fit rounded-lg border-b-4 border-r-4 border-sky-700/10 hover:border-sky-700/20 transition-all duration-500
      ease-in-out shadow-lg overflow-hidden grid grid-cols-1 md:grid-cols-2">
                <!-- Bal oldali oszlop - CSAK A KÉP -->
                <div id="productimg" class="rounded ">
                </div>
                
                <!-- Jobb oldali oszlop - MINDEN MÁS -->
                <div class="p-6">
                    <p class="text-sm text-gray-600 font-medium mb-2">
                        {{ category_name }}
                    </p>
                    
                    <h2 class="text-gray-900 font-bold text-xl mb-2">{{ title }} ({{ weight }}gr)</h2>
                    
                    <p class="text-sky-500 font-bold text-2xl mb-4">{{ price }} Ft</p>
                    
                    <div class="mb-4">
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-medium text-gray-700 mr-2">
                            {{ flavour }}
                        </span>
                    </div>
                    
                    <p class="text-gray-700 text-base">{{ description }}</p>
                    
                    <div class="mt-6">
                        <button class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded">
                            Kosárba
                        </button>
                    </div>
                </div>
            </div>
</template>

<script setup>


const props = defineProps({
    description: {
        type: String,
        required: true
    },
    flavour: {
        type: String,
        required: true
    },
    price: {
        type: Number,
        required: true,
    },
    weight: {
        type: Number,
        required: true,
    }
})
</script>
<style>
#productimg{
    background-image: url('../assets/product_img/scitec_wpp_2350.webp');
    background-position: center;
    background-size: cover;
    margin: auto;
    width: 250px;
    height: 250px;
}
</style>