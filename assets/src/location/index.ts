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
    }
}
