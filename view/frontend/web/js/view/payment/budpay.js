define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'budpay',
                component: 'Budpay_Payment/js/view/payment/method-renderer/budpay-method'
            }
        );

        console.log('Budpay added to rendererList', rendererList);

        return Component.extend({});
    }
);
