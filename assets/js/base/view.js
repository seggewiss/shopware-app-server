import Vue from 'vue';
import { location } from '@shopware-ag/admin-extension-sdk';
import '@shopware-ag/meteor-component-library/dist/style.css';

location.startAutoResizer();

const app = new Vue({
    el: '#app',
    data() {
        return { location }
    },
    components: {
        'TemplateListing': () => import('../views/template/listing'),
    },
    template: `
        <TemplateListing v-if="location.is('template-listing')"></TemplateListing>
    `,
})
