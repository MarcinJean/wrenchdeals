<template>
    <Dialog :open="open" @openChange="$emit('update:open', $event)">
        <DialogContent class="space-y-6">
            <DialogHeader>
                <DialogTitle class="text-lg font-bold">Send Coupon: {{ coupon.title }}</DialogTitle>
            </DialogHeader>
            <DialogDescription class="text-justify">
                <Tabs default-value="account" class="w-[400px]">
                    <TabsList class="grid w-full grid-cols-2">
                        <TabsTrigger value="email">Email</TabsTrigger>
                        <TabsTrigger value="Text">Text</TabsTrigger>
                        <TabsTrigger value="wallet">Wallet</TabsTrigger>
                    </TabsList>

                    <TabsContent value="email">
                        <Label class="block text-sm font-medium">Email</Label>
                        <Input
                            v-model="email"
                            type="email"
                            class="w-full border rounded px-3 py-2"
                            placeholder="you@example.com"
                        />
                        <button @click="sendEmail" class="mt-1 btn">Send Email</button>
                    </TabsContent>
                    <TabsContent value="text">
                        <Label class="block text-sm font-medium">Phone</Label>
                        <Input
                            v-model="phone"
                            type="tel"
                            class="w-full border rounded px-3 py-2"
                            placeholder="555-123-4567"
                        />
                        <button @click="sendSms" class="mt-1 btn">Send Text</button>
                    </TabsContent>
                    <TabsContent value="Wallet">
                        <Label class="block text-sm font-medium">Share Link</Label>
                        <div class="flex items-center">
                            <Input
                                v-model="shareLink"
                                readonly
                                class="flex-1 border rounded-l px-3 py-2"
                            />
                            <button @click="copyLink" class="btn rounded-r px-3">
                                Copy
                            </button>
                        </div>
                    </TabsContent>
                </Tabs>
                <DialogFooter>
                    <DialogClose asChild>
                        <button class="cursor-pointer rounded bg-gray-200 px-3 py-1 font-bold text-black">Close Disclaimer</button>
                    </DialogClose>
                </DialogFooter>
            </DialogDescription>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogFooter, DialogDescription, DialogClose
} from '@/components/ui/dialog';

import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from '@/components/ui/tabs'

import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

const props = defineProps<{
    open: boolean
    coupon: { id: number; title: string }
}>()

const emit = defineEmits<{
    (e: 'update:open', val: boolean): void
    (e: 'sent', payload: { method: string; details: any }): void
}>()

// Local state
const email = ref('')
const phone = ref('')
const shareLink = ref('')

// Update shareLink whenever coupon changes
watch(
    () => props.coupon,
    (c) => {
        shareLink.value = `${window.location.origin}/coupons/${c.id}`
    },
    { immediate: true }
)

// Stubbed API calls
async function sendEmail() {
    // await your API call...
    emit('sent', { method: 'email', details: { to: email.value } })
}
async function sendSms() {
    // await your API call...
    emit('sent', { method: 'sms', details: { to: phone.value } })
}
function printCoupon() {
    window.print()
    emit('sent', { method: 'print', details: {} })
}
function copyLink() {
    navigator.clipboard.writeText(shareLink.value)
    emit('sent', { method: 'link', details: { link: shareLink.value } })
}
</script>

<style scoped>

</style>
