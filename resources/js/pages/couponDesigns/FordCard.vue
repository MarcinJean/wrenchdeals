<script setup lang="ts">
defineProps({
    title: { type: String, required: true },
    description: { type: String, required: true },
    discount: { type: String, required: true },
    buttonText: { type: String, default: 'View Details' },
    image: { type: String, default: '' },
    expiry: { type: String, default: '' },
});
</script>

<template>
        <div class="w-full bg-gray-100 rounded-lg overflow-hidden shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center">
                <div class="md:w-1/3 flex-shrink-0">
                    <img v-if="image" :src="image" alt="Coupon Image" class="w-full object-cover rounded mb-4 md:mb-0 md:mr-6">
                </div>
                <div class="md:w-2/3">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ title }}</h4>
                    <p class="text-gray-700 mb-4">{{ description }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-blue-600">{{ discount }}</span>
                        <button class="bg-blue-600 text-white uppercase text-sm font-medium py-2 px-4 rounded shadow hover:bg-blue-700">
                            {{ buttonText }}
                        </button>
                    </div>
                </div>
            </div>
            <p v-if="expiry" class="text-sm text-gray-500 mt-4">Expires {{ expiry }}</p>
        </div>
</template>

<style scoped>

</style>
