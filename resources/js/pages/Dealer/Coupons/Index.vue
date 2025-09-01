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

const { instances } = usePage().props.value
</script>

<template>
    <div>
        <h1>Issued Coupons</h1>
        <table>
            <thead><tr>
                <th>Code</th><th>Status</th><th>Redeemed At</th><th>Actions</th>
            </tr></thead>
            <tbody>
            <tr v-for="c in instances.data" :key="c.id">
                <td>{{ c.code }}</td>
                <td>{{ c.status }}</td>
                <td>{{ c.redeemed_at || '–' }}</td>
                <td>
                    <inertia-link v-if="c.status==='issued'"
                                  :href="`/dealer/coupons/${c.id}/redeem`">
                        Redeem
                    </inertia-link>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination :links="instances.links" />
    </div>
</template>

<style scoped>

</style>
