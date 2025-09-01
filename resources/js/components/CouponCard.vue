<script setup lang="ts">
const props = defineProps({
    coupon: {
        type: Object,
        required: true,
        default: () => ({})
    }
})
</script>

<template>
    <div class="border border-gray-200 rounded-lg p-4 flex flex-col justify-between">
        <div>
            <img
                :src="coupon.icon"
                :alt="coupon.title"
                class="w-12 h-12 mb-3"
            />
            <div class="text-xl font-semibold mb-1">{{ coupon.title }}</div>
            <div class="text-blue-600 font-bold text-lg mb-2">{{ coupon.discount }}</div>
            <div class="text-gray-700 mb-2">{{ coupon.description }}</div>
            <ul class="list-disc ml-5 text-sm text-gray-600 mb-2">
                <li v-for="(term, index) in coupon.terms" :key="index">{{ term }}</li>
            </ul>
            <div class="text-sm text-gray-500">Expires: {{ coupon.expires }}</div>
            <div
                v-if="coupon.code"
                class="mt-1 text-sm font-mono bg-gray-100 inline-block p-1 rounded"
            >
                Code: {{ coupon.code }}
            </div>
        </div>
        <button
            class="mt-4 self-start bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
            View Details
        </button>
    </div>
</template>

<style scoped>

</style>
