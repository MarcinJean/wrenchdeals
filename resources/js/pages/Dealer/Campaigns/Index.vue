<script setup lang="ts">
import { usePage, Link as InertiaLink } from '@inertiajs/vue3'
import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from '@/components/ui/pagination'

const page      = usePage()
const campaigns = page.props.value.campaigns ?? { data: [], links: [] }
console.log(usePage().props.value); // Check the console output
</script>


<template>
    <div>
        <h1>Campaigns</h1>
        <inertia-link href="/dealer/campaigns/create" class="btn">New Campaign</inertia-link>
        <table>
            <thead><tr>
                <th>Name</th><th>Expires</th><th>Limit</th><th>Count</th><th>Actions</th>
            </tr></thead>
            <tbody>
            <tr v-for="c in (campaigns?.data || [])" :key="c.id">
                <td>{{ c.name }}</td>
                <td>{{ c.expires_at }}</td>
                <td>{{ c.generation_limit ?? '∞' }}</td>
                <td>{{ c.generation_count }}</td>
                <td>
                    <inertia-link :href="`/dealer/campaigns/${c.id}/edit`">Edit</inertia-link>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination :links="campaigns.links" />
    </div>
</template>
