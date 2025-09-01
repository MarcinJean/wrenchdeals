<script setup lang="ts">
import { defineProps } from 'vue';

interface Coupon { code: string; }

const props = defineProps<{ coupons: Coupon[]; apiBase: string }>();

function formatCode(raw: string): string {
    return raw.match(/.{1,4}/g)?.join('-') ?? raw;
}

function printCoupon() {
    window.print();
}

async function emailCoupon(code: string) {
    await fetch(`${props.apiBase}/coupons/email`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ code }),
    });
    alert('Coupon emailed!');
}
</script>

<template>
    <div class="space-y-4">
        <div v-for="coupon in coupons" :key="coupon.code" class="p-4 bg-white rounded shadow">
            <h2 class="text-xl font-semibold mb-2">Your Coupon</h2>
            <div class="font-mono text-lg mb-4">{{ formatCode(coupon.code) }}</div>
            <div class="flex gap-2">
                <button @click="printCoupon" class="px-4 py-2 border rounded">Print</button>
                <button @click="emailCoupon(coupon.code)" class="px-4 py-2 border rounded">Email Me</button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
