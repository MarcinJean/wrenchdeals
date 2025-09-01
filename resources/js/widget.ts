import { createApp } from 'vue';
import CouponList from '@/components/widget/CouponList.vue';

// Define the expected global config interface
interface WidgetConfig {
    apiVersion: string;  // e.g. 'v1'
    dealerId: number;
}

declare global {
    interface Window { WrenchDealsWidgetConfig?: WidgetConfig; }
}

// Initialize the widget once DOM is ready
async function initWidget() {
    const config = window.WrenchDealsWidgetConfig;
    if (!config) {
        console.error('WrenchDealsWidgetConfig is not defined');
        return;
    }
    const container = document.getElementById('wrenchdeals-coupon-widget');
    if (!container) return;

    const endpointBase = `/api/${config.apiVersion}`;

    try {
        // Fetch all active coupons for this dealer
        const res = await fetch(`${endpointBase}/coupons?dealer_id=${config.dealerId}`);
        if (!res.ok) throw new Error('Failed to fetch coupons');
        const coupons = await res.json();

        createApp(CouponList, {
            coupons,
            apiVersion: config.apiVersion
        }).mount(container);
    } catch (e) {
        console.error(e);
        container.innerHTML = '<p>Coupons unavailable</p>';
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initWidget);
} else {
    initWidget();
}
