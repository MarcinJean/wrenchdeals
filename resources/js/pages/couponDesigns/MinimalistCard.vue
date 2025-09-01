<script setup lang="ts">
    defineProps({
        title: String,
        description: String,
        discount: String,
        expiry: String,
    });
</script>

<template>
    <div class="w-full bg-gray-50 rounded-lg border border-gray-200 p-4">
        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ title }}</h3>
        <p class="text-gray-700 mb-2">{{ description }}</p>
        <div class="flex justify-between items-center">
            <span class="text-2xl font-semibold text-green-600">{{ discount }}</span>
            <p class="text-sm text-gray-500">Expires {{ expiry }}</p>
        </div>
    </div>
</template>

<style scoped>

</style>
