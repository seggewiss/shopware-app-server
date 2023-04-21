import * as sw from '@shopware-ag/admin-extension-sdk';

console.log('App');

if (sw.location.is(sw.location.MAIN_HIDDEN)) {
    sw.notification.dispatch({
        appearance: "notification",
        variant: "info",
        title: "App loaded",
        message: "Your app loaded. Adjust the admin-sdk.js file."
    });
}
