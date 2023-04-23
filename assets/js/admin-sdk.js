import * as sw from '@shopware-ag/admin-extension-sdk';

if (sw.location.is(sw.location.MAIN_HIDDEN)) {
    import('./base/main-hidden');
} else {
    import('./base/view');
}
