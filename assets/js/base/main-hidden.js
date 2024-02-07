import * as sw from "@shopware-ag/meteor-admin-sdk";

console.log('Hello from main-hidden.js');
sw.ui.menu.addMenuItem({
    label: 'Custom products app',
    parent: 'sw-catalogue',
    displaySearchBar: true,
    locationId: 'template-listing',
    position: 999,
})

sw.ui.componentSection.add({
    component: 'card',
    positionId: 'sw-order-detail-general-info__after',
    props: {
        title: 'Order debug',
        locationId: 'order-debug',
    }
})

sw.ui.componentSection.add({
    component: 'card',
    positionId: 'sw-sales-channel-detail-base-general__after',
    props: {
        title: 'SalesChannel debug',
        locationId: 'sales-channel-debug',
    }
})