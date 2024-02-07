import Vue from 'vue';
import { location } from '@shopware-ag/meteor-admin-sdk';
import '@shopware-ag/meteor-component-library/dist/style.css';

location.startAutoResizer();

const app = new Vue({
    el: '#app',
    data() {
        return { location }
    },
    components: {
        'Order': () => import('../views/template/order'),
        'SalesChannel': () => import('../views/template/sales-channel'),
    },
    template: `
        <div>
            <Order v-if="location.is('order-debug')"></Order>
            <SalesChannel v-if="location.is('sales-channel-debug')"></SalesChannel>
        </div>
    `,
})
