<template>
    <BaseLayout>
        <div
            class="flex mx-auto justify-center items-center my-20 bg-sky-500 py-4 text-white rounded-2xl border-4 border-sky-700/45 shadow-2xl">
            <p class="m-auto font-semibold text-xl"> Mikor máskor, ha nem éjfélkor?!</p>
            <p class="m-auto font-semibold text-xl">Valaki szabadítsa fel Dobby-t!</p>
        </div>
        <div
            class="flex w-1/5 min-h-[200px] mx-auto justify-center items-center my-20 bg-sky-500 py-4 text-white rounded-2xl border-4 border-slate-600/55 shadow-2xl">
            <div class="flex flex-col justify-center items-center mx-auto font-semibold text-xl">
                <span class="bg-white max-w-fit text-center rounded-full text-2xl ">🧝‍♂️</span>
                <p>Master Has</p>
                <p class="mb-1">Given Dobby a </p>
                <span class="bg-white max-w-fit text-center rounded-full text-2xl">🧦</span>
            </div>
        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from '@layouts/BaseLayout.vue';

</script>