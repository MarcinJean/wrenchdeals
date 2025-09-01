<script setup lang="ts">
    defineProps({
        title: String,
        description: String,
        discount: String,
        expiry: String,
    });
</script>

<template>
    <div class="w-full bg-gray-800 rounded-lg shadow-lg overflow-hidden p-6 text-white">
        <h3 class="text-2xl font-bold mb-2">{{ title }}</h3>
        <p class="text-gray-300 mb-4">{{ description }}</p>
        <div class="bg-gray-700 p-4 rounded mb-4">
            <span class="text-3xl font-bold">{{ discount }}</span>
            <span class="ml-1 text-gray-400">off</span>
        </div>
        <p class="text-sm text-gray-400">Expires {{ expiry }}</p>
        <button class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Redeem Now</button>
    </div>
</template>

<style scoped>

</style>
