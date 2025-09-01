<script setup lang="ts">
defineProps({
    title: { type: String, required: true },
    description: { type: String, required: true },
    image: { type: String, default: '' },
    discount: { type: String, required: true },
    expiry: { type: String, required: true },
    badgeText: { type: String, default: 'Hot Deal' }
});
</script>

<template>
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden p-6">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-xl font-medium text-gray-900">{{ title }}</h3>
            <span class="text-sm text-gray-600">Expires {{ expiry }}</span>
        </div>
        <p class="text-gray-700 mb-4">{{ description }}</p>
        <div class="flex items-center mb-6">
            <div class="text-4xl font-bold text-blue-600">{{ discount }}</div>
            <button class="ml-auto bg-blue-600 text-white uppercase text-sm font-medium py-2 px-4 rounded shadow hover:bg-blue-700 focus:outline-none">
                Redeem
            </button>
        </div>
        <img v-if="image" :src="image" alt="Coupon Image" class="w-full h-48 object-cover rounded">
    </div>
</template>

<style scoped>

</style>
