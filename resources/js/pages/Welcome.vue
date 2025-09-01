<script setup>
import { ref } from 'vue'
import NavBar from '@/components/NavBar.vue'
import FilterBar from '@/components/FilterBar.vue'
import CouponCard from '@/components/CouponCard.vue'

const coupons = ref([
    {
        id: 1,
        title: 'Brake Pads & Rotor Service',
        description: 'Includes parts and labor for brake pads and rotors.',
        discount: '$50 OFF',
        terms: ['Valid on front or rear axle', 'Limit one per vehicle'],
        expires: '08/31/25',
        icon: '/icons/brake.svg',
        code: 'BP50OFF'
    },
    {
        id: 2,
        title: 'Full Synthetic Oil Change',
        description: 'Up to 5 quarts of full synthetic oil plus filter replacement.',
        discount: '$20 OFF',
        terms: ['Excludes diesel and EV', 'Must present coupon at time of service'],
        expires: '09/15/25',
        icon: '/icons/oil-change.svg',
        code: 'OIL20'
    },
    {
        id: 3,
        title: 'Wheel Alignment',
        description: 'Precision alignment for optimal tire wear and handling.',
        discount: '10% OFF',
        terms: ['Includes 4-wheel alignment', 'Tire balance extra'],
        expires: '07/30/25',
        icon: '/icons/alignment.svg',
        code: 'ALIGN10'
    },
    {
        id: 4,
        title: 'Pre-Summer Inspection',
        description: 'Comprehensive check of A/C and cooling system.',
        discount: 'Free',
        terms: ['Up to 1 hour of inspection', 'Additional repairs extra'],
        expires: '06/01/25',
        icon: '/icons/inspection.svg',
        code: 'SUMMERCHK'
    },
]);

const dealerId    = 123
const apiVersion  = 'v1'

// 3. On mount, set up the global config and kick off the widget
import { onMounted } from 'vue'
import CouponList from '@/components/widget/CouponList.vue';

onMounted(() => {
    // attach global config
    window.WrenchDealsWidgetConfig = { dealerId, apiVersion }
    // initialize the widget into the <div>
    initWidget()
})

async function initWidget() {
    const config = window.WrenchDealsWidgetConfig
    if (!config) {
        console.error('WrenchDealsWidgetConfig is not defined')
        return
    }
    const container = document.getElementById('wrenchdeals-coupon-widget')
    if (!container) return

    const endpointBase = `/api/${config.apiVersion}`

    try {
        const res = fetch(`${endpointBase}/coupons?dealer_id=${config.dealerId}`)
        if (!res.ok) throw new Error('Failed to fetch coupons')
        const coupons =  res.json()

        createApp(CouponList, { coupons, apiVersion: config.apiVersion })
            .mount(container)
    } catch (e) {
        console.error(e)
        container.innerHTML = '<p>Coupons unavailable</p>'
    }
}

</script>

<template>
    <NavBar />
    <div id="wrenchdeals-coupon-widget"></div>
</template>
