<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import Multiselect from 'vue-multiselect'

const page = usePage()
console.log(page.props);

// Safely compute each prop (defaults to empty array if undefined)
const serviceCategories = computed(
    () => page.props.serviceCategories ?? []
)
const vehicleMakes = computed(
    () => page.props.vehicleMakes ?? []
)
const dealers = computed(
    () => page.props.dealers ?? []
)

const form = useForm({
    name:               '',
    start_at:           '',
    expires_at:         '',
    generation_limit:   null,
    service_categories: [],
    vehicle_makes:      [],
    dealers:            [],
})

function submit() {
    form.post(route('dealer.campaigns.store'))
}
</script>

<template>
    <div class="max-w-2xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">New Coupon Campaign</h1>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="block font-medium">Name</label>
                <input v-model="form.name"
                       type="text"
                       class="w-full border rounded px-3 py-2"
                       placeholder="Campaign Name" />
                <p v-if="form.errors.name" class="text-red-600 mt-1">{{ form.errors.name }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Start Date</label>
                    <input v-model="form.start_at"
                           type="datetime-local"
                           class="w-full border rounded px-3 py-2" />
                    <p v-if="form.errors.start_at" class="text-red-600 mt-1">{{ form.errors.start_at }}</p>
                </div>
                <div>
                    <label class="block font-medium">Expires On</label>
                    <input v-model="form.expires_at"
                           type="date"
                           class="w-full border rounded px-3 py-2" />
                    <p v-if="form.errors.expires_at" class="text-red-600 mt-1">{{ form.errors.expires_at }}</p>
                </div>
            </div>

            <div>
                <label class="block font-medium">Max Generations</label>
                <input v-model="form.generation_limit"
                       type="number"
                       min="1"
                       class="w-full border rounded px-3 py-2"
                       placeholder="Leave blank for unlimited" />
                <p v-if="form.errors.generation_limit" class="text-red-600 mt-1">{{ form.errors.generation_limit }}</p>
            </div>

            <div>
                <label class="block font-medium">Service Categories</label>
                <multiselect :options="serviceCategories" :multiple="true" class="w-full border rounded px-3 py-2">
                </multiselect>
                <p v-if="form.errors.service_categories" class="text-red-600 mt-1">{{ form.errors.service_categories }}</p>
            </div>

            <div>
                <label class="block font-medium">Vehicle Makes</label>
                <select v-model="form.vehicle_makes"
                        multiple
                        class="w-full border rounded px-3 py-2">
                    <option v-for="m in vehicleMakes" :key="m.id" :value="m.id">
                        {{ m.name }}
                    </option>
                </select>
                <p v-if="form.errors.vehicle_makes" class="text-red-600 mt-1">{{ form.errors.vehicle_makes }}</p>
            </div>

            <div>
                <label class="block font-medium">Locations</label>
                <select v-model="form.dealers"
                        multiple
                        class="w-full border rounded px-3 py-2">
                    <option v-for="d in dealers" :key="d.id" :value="d.id">
                        {{ d.name }}
                    </option>
                </select>
                <p v-if="form.errors.dealers" class="text-red-600 mt-1">{{ form.errors.dealers }}</p>
            </div>

            <div class="pt-4">
                <button type="submit"
                        :disabled="form.processing"
                        class="px-4 py-2 bg-blue-600 text-white rounded">
                    Create Campaign
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
