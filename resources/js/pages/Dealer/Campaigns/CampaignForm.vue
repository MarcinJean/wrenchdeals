<script setup lang="ts">
import { reactive, toRefs } from 'vue'

defineProps({
    initialData: Object,
    categories: Array,
    makes: Array,
    dealers: Array,
    actionUrl: String,
    method: String,
})

const form = reactive({
    name              : props.initialData.name || '',
    expires_at        : props.initialData.expires_at || '',
    generation_limit  : props.initialData.generation_limit ?? null,
    serviceCategories : props.initialData.service_categories?.map(c => c.id) || [],
    vehicleMakes      : props.initialData.vehicle_makes?.map(m => m.id) || [],
    dealers           : props.initialData.dealers?.map(d => d.id) || [],
})
</script>

<template>
    <form :action="actionUrl" :method="method">
        <div>
            <label>Name</label>
            <input v-model="form.name" name="name" required />
        </div>
        <div>
            <label>Expires On</label>
            <input type="date" v-model="form.expires_at" name="expires_at" required />
        </div>
        <div>
            <label>Max Generations</label>
            <input type="number" v-model="form.generation_limit" name="generation_limit" />
        </div>
        <div>
            <label>Service Categories</label>
            <select v-model="form.serviceCategories" multiple name="serviceCategories">
                <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
            </select>
        </div>
        <div>
            <label>Vehicle Makes</label>
            <select v-model="form.vehicleMakes" multiple name="vehicleMakes">
                <option v-for="m in makes" :key="m.id" :value="m.id">{{ m.name }}</option>
            </select>
        </div>
        <div>
            <label>Locations</label>
            <select v-model="form.dealers" multiple name="dealers">
                <option v-for="d in dealers" :key="d.id" :value="d.id">{{ d.name }}</option>
            </select>
        </div>
        <button type="submit">Save</button>
    </form>
</template>

<style scoped>

</style>
