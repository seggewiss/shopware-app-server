// import type { I18n } from '@/i18n';
import * as sw from '@shopware-ag/meteor-admin-sdk';

// export async function addLocations(paymentMethod: EntitySchema.Entity<'payment_method'>, i18n: I18n) {
export async function addLocations() {
    if (sw.location.is(sw.location.MAIN_HIDDEN)) {
        sw.ui.menu.addMenuItem({
            label: 'Segge Test App',
            locationId: 'test-module',
        });

        sw.ui.actionButton.add({
            name: 'test-action-button',
            label: 'Foo',
            entity: 'product',
            view: 'list',
            callback: (entity, idList) => {
                console.log('SDK: product action button submitted', entity, idList);
            },
        });

        sw.ui.actionButton.add({
            name: 'test-action-button',
            label: 'Foo',
            entity: 'promotion',
            view: 'list',
            callback: (entity, idList) => {
                console.log('SDK: promotion action button submitted', entity, idList);
            },
        });

        sw.ui.sidebar.open({
            title: 'Awesome Chat Bot',
            locationId: 'sidebar-foo',
            icon: 'regular-sparkles',
        });

        sw.ui.sidebar.open({
            title: 'Bar',
            locationId: 'sidebar-bar',
            icon: 'solid-activity',
            variant: 'default',
            mode: 'push',
        });

        const CMS_ELEMENT_NAME = 'swag-dailymotion';
        const CONSTANTS = {
            CMS_ELEMENT_NAME,
            PUBLISHING_KEY: `${CMS_ELEMENT_NAME}__config-element`,
        };

        console.log('SDK: CMS_ELEMENT_NAME', CMS_ELEMENT_NAME);
        void sw.cms.registerCmsElement({
            name: CONSTANTS.CMS_ELEMENT_NAME,
            label: 'Dailymotion video',
            defaultConfig: {
                dailyUrl: {
                    source: 'static',
                    value: '',
                },
            },
        });

        console.log('adding main module');
        void sw.ui.mainModule.addMainModule({
            heading: 'foo',
            locationId: 'main-module',
        });
    }
}
