<script setup lang="ts">
    const props = defineProps({
        couponId: { type: [String, Number], required: true },
        badgeText: { type: String, default: '' },
        title: { type: String, required: true },
        showTitle: { type: Boolean, default: false },
        discount: { type: String, required: true },
        image: { type: String, default: '' },
        expiry: { type: String, default: '' },
        showVideo: { type: Boolean, default: false },
        description: { type: String, default: '' },
        showDisclaimer: { type: Boolean, default: true },
        color: { type: String, default: '00000' },
        type: { type: String, default: '' },
    });

    const emit = defineEmits([
        'watch-video',
        'openSendDialog',
        'toggle-disclaimer'
    ]);

    const BGColor = 'background-color: #'+props.color;
</script>

<template>
    <div class="w-full bg-white rounded-lg overflow-hidden shadow-xl/30">
        <!-- Image & Overlays -->
        <div class="relative h-64">
            <img :src="image" alt="Coupon Image" class="object-cover w-full h-full" />
            <div class="absolute top-4 right-0">
                <span class="px-3 py-1 text-white uppercase text-xl font-bold" :style="BGColor">{{ badgeText }}</span>
            </div>
            <!-- Title & Price -->
            <div v-if="showTitle" class="absolute inset-x-0 top-12 flex items-center justify-between px-4 bg-gray-950/50">
                <div>
                    <h3 class="text-white text-xl font-bold leading-tight">{{ title }}</h3>
                    <p class="text-white text-2xl font-semibold">{{ discount }}</p>
                </div>
            </div>
            <!-- Expiry Footer Overlay -->
            <div class="absolute inset-x-0 bottom-0 px-4 py-2 flex items-center justify-between bg-gray-950/50">
                <div class="text-white text-sm"> Expires {{ expiry }}</div>

                <button
                    v-if="showVideo"
                    @click.stop="emit('watch-video', couponId)"
                    class="flex items-center text-white text-sm font-medium px-3 py-2 rounded-full cursor-pointer" :style="BGColor"
                >
                    <span class="">Watch Video</span>
                </button>
                <div class="text-white text-sm font-bold uppercase" v-if="type === 'manufacturer'">Manufacturer Special</div>
            </div>
        </div>

        <!-- Action Buttons with Custom Shadows -->
        <div class="flex justify-around py-3 action-row text-white cursor-pointer" :style="BGColor" @click.stop="emit('openSendDialog', couponId)">
            <button class="flex flex-row items-center cursor-pointer">
                <!-- Claim Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M2.273 5.625A4.483 4.483 0 0 1 5.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0 0 18.75 3H5.25a3 3 0 0 0-2.977 2.625ZM2.273 8.625A4.483 4.483 0 0 1 5.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0 0 18.75 6H5.25a3 3 0 0 0-2.977 2.625ZM5.25 9a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3v-6a3 3 0 0 0-3-3H15a.75.75 0 0 0-.75.75 2.25 2.25 0 0 1-4.5 0A.75.75 0 0 0 9 9H5.25Z" />
                </svg>
                <span class="text-lg ml-1">Claim Service Special!</span>
            </button>
        </div>

        <!-- Details Section -->
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-900">{{ title }}</h3>
            <p class="text-orange-500 text-xl font-bold mb-2">{{ discount }}</p>
            <p class="text-gray-700 text-sm transition-all inline">{{ description }}</p>


            <div v-if="showDisclaimer" @click.stop="emit('toggle-disclaimer', couponId)" class="mt-2 text-sm text-orange-500 font-medium">
                <span class="cursor-pointer">Disclaimer</span>
            </div>
        </div>
    </div>
</template>

<style scoped>
.action-row {
    /* subtle top inset shadow and mirrored bottom shadow */
    box-shadow: inset 0 4px 6px -4px rgba(0, 0, 0, 0.25),
    0 4px 6px -4px rgba(0, 0, 0, 0.25);
}
</style>
