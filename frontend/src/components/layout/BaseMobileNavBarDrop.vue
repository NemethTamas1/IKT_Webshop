<template>
    <li
        class="text-lg flex justify-between items-center  rounded px-2 text-sky-900 hover:bg-sky-400/85 hover:text-white py-3 has-[.active]:bg-sky-200/60 has-[.active]:hover:text-sky-500">
        <RouterLink :to="linkText" class="block w-full">{{menuOption}}</RouterLink>
    </li>
</template>

<script setup>
const props = defineProps({
    linkText: {
        type: String,
        required: true,
    },
    menuOption: {
        type: String,
        required: true,
    }
})
</script>