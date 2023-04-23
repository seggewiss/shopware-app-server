import * as sw from "@shopware-ag/admin-extension-sdk";

sw.ui.menu.addMenuItem({
    label: 'Custom products app',
    parent: 'sw-catalogue',
    displaySearchBar: true,
    locationId: 'template-listing',
    position: 999,
})
