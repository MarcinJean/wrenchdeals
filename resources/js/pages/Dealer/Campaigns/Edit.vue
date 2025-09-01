<script setup lang="ts">
    import { usePage } from '@inertiajs/vue3'
    import CampaignForm from '@/Pages/Dealer/Campaigns/CampaignForm.vue'

    const { campaign, serviceCategories, vehicleMakes, dealers } = usePage().props.value
</script>

<template>
    <div>
        <h1>Edit Campaign</h1>
        <CampaignForm :categories="serviceCategories"
                      :makes="vehicleMakes"
                      :dealers="dealers"
                      :initial-data="campaign"
                      action-url={/dealer/campaigns/${campaign.id}}
                      method="put" />
    </div>
</template>

<style scoped>

</style>
