<script setup lang="ts">
    defineProps({
        title: String,
        description: String,
        image: { type: String, default: '' },
        discount: String,
        expiry: String,
    });
</script>

<template>
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <img v-if="image" :src="image" alt="Coupon Image" class="w-full h-40 object-cover">
        <div class="p-4 flex flex-col justify-between">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ title }}</h3>
            <p class="text-gray-600 mb-2">{{ description }}</p>
            <div class="flex items-center justify-between">
                <span class="text-xl font-bold text-green-600">{{ discount }}</span>
                <p class="text-sm text-gray-400">Expires {{ expiry }}</p>
            </div>
            <button class="mt-3 w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Redeem</button>
        </div>
    </div>
</template>

<style scoped>

</style>
