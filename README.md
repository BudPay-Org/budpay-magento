# Budpay Magento

A magento module that allows you to accept payment on Magento 2x

## Requirements
- Existing Magento2x installation on your web server.
- Budpay Merchant Secret Key 
- Download the latest plugin from the latest release page.
- Take payments on your magento 2 store using Budpay Payments.

## Support for:

 - Credit card
 - Bank Transfer

## Installation

### Manual Installation

*  Click the Download Zip button and save to your local machine.
*  Unpack(Extract) the archive.
*  Create a __Budpay/Payment__ folder in your Magento's __app/code__ directory.
*  Copy the content into your Magento's __app/code/Budpay/Payment__ directory.

### Enable the Rave Payments module:

*  From your commandline, in your magento root directory, run
   
```bash
php bin/magento module:enable Budpay_Payment --clear-static-content
php bin/magento setup:upgrade
php bin/magento setup:di:compile
```

*  Once the `setup:upgrade` completes the module will be available in the Store Admin.



### Configure the plugin

Configuration can be done using the Administrator section of your Magento store.

* From the admin dashboard, using the left menu navigate to __Stores__ > __Configuration__ > __Sales__ > __Payment Methods__.
* Select __Budpay Payment__ from the list of recommended modules.
* Set __Enable__ to __Yes__ and fill the rest of the config form accordingly, then click __Save Config__ to save and activate.
  Note: Your Merchant Secret Key is required to activate this module for cart checkout.

