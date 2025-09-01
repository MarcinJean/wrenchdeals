<template>

    <Dialog :open="open">
        <DialogContent class="space-y-6 p-0 gap-0">
            <DialogHeader class="m-0 p-6  pt-3 pb-0">
                <DialogTitle class="text-2xl font-bold">Claim Service Special</DialogTitle>
            </DialogHeader>
            <DialogDescription class="text-justify">
                <div class="pl-6 pr-6 pb-0 text-lg font-semibold">{{ coupon.title }} - {{coupon.discount}}</div>
                <div class="text-center pb-2">Choose how you wish to receive your service special:</div>
                <Tabs default-value="account">
                    <TabsList class="grid w-full grid-cols-3 rounded-none p-0">
                        <TabsTrigger value="email" class="rounded-none">Email</TabsTrigger>
                        <TabsTrigger value="text" class="rounded-none">Text</TabsTrigger>
                        <TabsTrigger value="wallet" class="rounded-none">Wallet</TabsTrigger>
                    </TabsList>

                    <TabsContent value="email" class="p-6 pt-1 pb-0">
                        <div class="flex items-center space-x-2 mb-2">
                            <Label class="block text-sm font-medium w-32">Email</Label>
                            <Input
                                v-model="email"
                                type="email"
                                class="w-full border rounded px-3 py-2"
                                placeholder="you@example.com"
                            />
                        </div>
                        <Button @click="sendEmail" class="mt-1 w-full text-white" :style="BGColor">Email Service Special</Button>
                    </TabsContent>
                    <TabsContent value="text" class="p-6 pt-1 pb-0">
                        <div class="flex items-center space-x-2 mb-2">
                            <Label class="block font-medium w-32">Phone</Label>
                            <Input
                                v-model="phone"
                                type="tel"
                                class="w-full border rounded px-3 py-2"
                                placeholder="555-123-4567"
                            />
                        </div>
                        <Button @click="sendSms" class="mt-1 w-full text-white" :style="BGColor">Text Service Special</Button>
                    </TabsContent>
                    <TabsContent value="wallet" class="p-6 pt-1 pb-0">
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
    DialogFooter, DialogClose, DialogDescription
} from '@/components/ui/dialog';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';

const props = defineProps<{
    open: boolean
    coupon: object
    color: string
}>()

const BGColor = 'background-color: #'+props.coupon.color;

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
function copyLink() {
    navigator.clipboard.writeText(shareLink.value)
    emit('sent', { method: 'link', details: { link: shareLink.value } })
}
</script>

<style scoped>

</style>
