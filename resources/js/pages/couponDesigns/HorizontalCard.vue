<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'

defineProps({
    title: { type: String, required: true },
    description: { type: String, required: true },
    image: { type: String, default: '' },
    discount: { type: String, required: true },
    expiry: { type: String, required: true },
});
</script>

<template>
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden p-4 flex">
        <img v-if="image" :src="image" alt="Coupon Image" class="w-24 h-24 object-cover rounded mr-4">
        <div class="flex flex-col justify-between flex-1">
            <div>
                <h3 class="text-xl font-bold text-gray-800">{{ title }}</h3>
                <p class="text-gray-600">{{ description }}</p>
            </div>
            <div class="mt-2 flex items-baseline">
                <span class="text-2xl font-semibold text-green-600">{{ discount }}</span>
                <span class="text-gray-500 ml-1">off</span>
            </div>
            <p class="text-sm text-gray-400">Expires {{ expiry }}</p>
            <button class="mt-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Redeem</button>
        </div>
    </div>
</template>

<style scoped>

</style>
