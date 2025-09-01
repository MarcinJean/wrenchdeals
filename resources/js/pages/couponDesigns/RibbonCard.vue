<script setup lang="ts">
defineProps({
    title: String,
    description: String,
    discount: String,
    expiry: String,
    badgeText: { type: String, default: 'Hot Deal' },
});
</script>

<template>
    <div class="relative w-full bg-white rounded-lg shadow-lg overflow-hidden p-4">
        <div class="absolute top-0 right-0">
            <span class="px-3 py-1 bg-red-500 text-white uppercase text-xs font-bold">{{ badgeText }}</span>
        </div>
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">{{ title }}</h3>
            <p class="text-gray-600 mb-2">{{ description }}</p>
            <div class="flex items-baseline">
                <span class="text-2xl font-semibold text-green-600">{{ discount }}</span>
                <span class="text-gray-500 ml-1">off</span>
            </div>
            <p class="text-sm text-gray-400">Expires {{ expiry }}</p>
            <button class="mt-3 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Redeem</button>
        </div>
    </div>
</template>

<style scoped>

</style>
