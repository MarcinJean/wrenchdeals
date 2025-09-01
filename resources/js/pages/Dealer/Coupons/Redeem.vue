<template>
    <div class="mx-auto mt-12 max-w-6xl">
        <h1 class="mb-6 text-2xl font-semibold">Redeem a Coupon</h1>

        <!-- Success / Error Alerts -->
        <div v-if="flash.success" class="mb-4 rounded bg-green-100 p-3 text-green-800">
            {{ flash.success }}
        </div>
        <div v-if="flash.error" class="mb-4 rounded bg-red-100 p-3 text-red-800">
            {{ flash.error }}
        </div>

        <form @submit.prevent="openDrawer" class="space-y-4">

            <div class="card flex justify-center">

                <PinInput id="code" name="coupon" @keydown="checkInput" v-model="value" placeholder="" @complete="handleComplete" :disabled="form.processing">
                    <p v-if="form.errors.coupon" class="text-red-600 mt-1">{{ form.errors.coupon }}</p>
                    <PinInputGroup class="gap-0">
                        <template v-for="(id, index) in 10" :key="id">
                            <PinInputSlot class="custom-otp-input border" :index="index" />
                            <template v-if="index == 2">
                                <PinInputSeparator />
                            </template>
                            <template v-if="index == 7">
                                <PinInputSeparator />
                            </template>
                        </template>
                    </PinInputGroup>
                </PinInput>
                <div style="width:180px;" class="ml-5">
                    <button type="submit" :disabled="form.processing" class="w-full rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 h-12">
                        {{ form.processing ? 'Redeeming…' : 'Redeem Coupon' }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <Drawer direction="top" v-model:open="isOpen" :handle="false" :dismissible="false" :onOpenChange="handleOpenChange">
        <DrawerContent>
            <div class="mx-auto w-full max-w-lg">
            <DrawerHeader class="gap-0 mt-3">
                <DrawerTitle>Redeem Coupon Code {{ formatPhoneLike(pin) }}</DrawerTitle>
                <DrawerDescription>This action cannot be undone.</DrawerDescription>
            </DrawerHeader>
                <p>{{ couponCampaign.name }}</p>
                <p>{{ couponCampaign.description }}</p>
            <div class="p-4 pb-0">
                <div class="flex flex-col space-y-4 w-full">
                    <div class="w-full">
                        <input
                            v-model="form.repair_order_id"
                            id="repair_order_id"
                            type="text"
                            class="w-full border rounded px-3 py-2"
                            placeholder="Repair Order Number"
                        />
                        <p v-if="form.errors.repair_order_id" class="text-red-600 mt-1">{{ form.errors.repair_order_id }}</p>
                    </div>

                    <div class="w-full">
                        <input
                            v-model="form.code"
                            id="code"
                            type="text"
                            class="w-full border rounded px-3 py-2"
                            placeholder="Enter Full 17 Character VIN"
                        />
                        <p v-if="form.errors.code" class="text-red-600 mt-1">{{ form.errors.code }}</p>
                    </div>

                </div>

            </div>

            <DrawerFooter class="mb-3">
                <div class="flex justify-between w-full">
                    <DrawerClose>
                        <Button variant="outline"> Cancel Redeem </Button>
                    </DrawerClose>
                    <Button variant="default"> Redeem Coupon </Button>
                </div>
            </DrawerFooter>
            </div>
        </DrawerContent>
    </Drawer>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { PinInput, PinInputGroup, PinInputSeparator, PinInputSlot } from '@/components/ui/pin-input';
import { Drawer, DrawerClose, DrawerContent, DrawerDescription, DrawerFooter, DrawerHeader, DrawerTitle } from '@/components/ui/drawer';
import { Button } from '@/components/ui/button';
import { useAPIForm } from '@/lib/useAPIForm';

function checkInput(event: any) {
    const allowed = /[A-Za-z0-9]/;
    if (!allowed.test(event.key)) {
        event.preventDefault();
    }
}

// Grab page props as a ref
const page = usePage();

// Defensive flash getter—default to empty object if page.props.value.flash is undefined
const flash = computed(() => {
    return {
        success: page.props.flash?.success || null,
        error: page.props.flash?.error || null,
    };
});

// Define the Inertia form for redemption
const form = useAPIForm({
    coupon: '',
});

const isOpen = ref(false);

const pin = ref();

const couponCampaign = ref();

const handleComplete = (e: string[]) => {
    pin.value = e.join('');
    form.processing = true;
    form.coupon = pin.value;
    form.post(route('dealer.coupons.validate'), {
        preserveScroll: true,
        onSuccess: (response) => {
            form.reset('coupon');
            couponCampaign.value = response.campaign;
            if(response.error == false) {
                openDrawer();
            }else{
                const inputElement = document.querySelector('input[data-slot="pin-input-slot"]')
                inputElement.attr("aria-invalid", "true");;
                form.errors.coupon = response.message;
            }
        },
    });
};

function formatPhoneLike(input: number | string): string {
    const str = input.toString();
    if (str.length !== 10) {
        throw new Error('Input must be exactly 10 digits');
    }
    return `${str.slice(0, 3)}-${str.slice(3, 8)}-${str.slice(8)}`;
}

function openDrawer() {
    isOpen.value = true;
}

function handleOpenChange(value: boolean) {
    isOpen.value = value;
    console.log(value);
}

const value = ref<string[]>([]);
</script>

<style scoped>
.custom-otp-input {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background: transparent;
    border: 1px solid;
    border-radius: 0;
    border-right: 0;
    color: inherit;
    font-size: 24px;
    height: 48px;
    outline-color: transparent;
    outline-offset: -2px;
    text-align: center;
    width: 48px;
    margin: 0px;
    border-color: var(--border);
}

.custom-otp-input:focus {
    outline: 2px solid var(--ring);
}

.custom-otp-input:first-child,
.custom-otp-input:nth-child(5),
.custom-otp-input:nth-child(11) {
    border-top-left-radius: 6px;
    border-bottom-left-radius: 6px;
}

.custom-otp-input:nth-child(3),
.custom-otp-input:nth-child(9),
.custom-otp-input:last-child {
    border-top-right-radius: 6px;
    border-bottom-right-radius: 6px;
    border-right-width: 1px;
    border-right-style: solid;
}
</style>
