<template>
    <div class="grid grid-cols-2">
        <div v-for="product in products" :key="product.id" class="mx-auto mt-12 px-6 w-4/5 rounded-lg border-b-4 border-r-4 border-sky-700/10
         hover:border-sky-700/20 transition-all duration-300
        ease-in-out shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-2 hover:scale-105 cursor-pointer">
            <div class="h-64 overflow-hidden bg-gray-100 flex items-center justify-center my-auto">
                <img :src="getImagePath(product.weight, product.flavour)" :alt="product.description"
                    class="max-w-[200px] max-h-[200px] ">

            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 font-medium mb-2">
                    {{ product.description }}
                </p>
                <h2 class="text-gray-900 font-bold text-xl mb-2">
                    {{ product.categories[0].brand }} 
                </h2>
                <p class="text-sky-500 font-bold text-2xl mb-4">{{ product.price }} Ft</p>

                <div class="mb-4">
                    <span
                        class="inline-block bg-sky-100  rounded-2xl px-3 py-1 text-sm font-medium text-gray-700 mr-2">
                        {{ product.flavour }}
                    </span>
                </div>
                <p class="text-gray-700 text-base">{{ product.weight }} gr</p>
                <div class="mt-6">
                    <button class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded">
                        Kosárba
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    products: {
        type: Array,
        required: true
    }
})
const images = import.meta.glob('@/assets/products_img/Scitec/wpp/**/*.webp', { eager: true })
const getImagePath = (weight, flavor) => {
    const key = Object.keys(images).find(path =>
        path.includes(`${weight}/${weight}_${flavor}.webp`)
    )
    console.log(key ? images[key].default : '');
    return key ? images[key].default : ''
}
</script>