import * as sw from '@shopware-ag/meteor-admin-sdk';
import App from '@/App.vue';
import { createApp } from 'vue';
import { DeviceHelperPlugin, TooltipDirective } from '@shopware-ag/meteor-component-library';
import { createI18n } from '@/i18n';
import { addLocations } from '@/location';
import { createPinia } from 'pinia';

void Promise.all([
    sw.context.getLocale(),
]).then(async ([locale]) => {
    const i18n = createI18n(locale);
    const pinia = createPinia();

    const app = createApp(App)
        .use(pinia)
        .use(i18n)
        .use(DeviceHelperPlugin)
        .directive('tooltip', TooltipDirective);

    await addLocations();

    app.mount('#app');

    sw.location.startAutoResizer();
});
