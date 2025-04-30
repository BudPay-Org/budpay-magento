define([
    'Magento_Checkout/js/view/payment/default',
    'mage/url'
], function (Component, url) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Budpay_Payment/payment/budpay',
            redirectAfterPlaceOrder: false
        },

        getCode: function() {
            return 'budpay';
        },

        getData: function() {
            return {
                'method': this.item.method,
                'additional_data': {}
            };
        },

        afterPlaceOrder: function() {
            window.location.replace(url.build('budpay/redirect'));
        }
    });
});
