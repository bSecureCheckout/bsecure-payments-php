<p align="center">
  <img src="https://bsecure-dev.s3-eu-west-1.amazonaws.com/dev/react_app/assets/secure_logo.png" width="400px" position="center">
</p>


[![Latest Version on Packagist](https://img.shields.io/packagist/v/bsecure/bsecure-payments.svg?style=flat-square)](https://packagist.org/packages/bsecure/bsecure-payments)
[![Latest Stable Version](https://poser.pugx.org/bsecure/bsecure-payments/v)](//packagist.org/packages/bsecure/bsecure-payments) 
[![Total Downloads](https://img.shields.io/packagist/dt/bSecureCheckout/bsecure-payments-php.svg?style=flat-square)](https://packagist.org/packages/bsecure/bsecure-payments)
[![License](https://poser.pugx.org/bsecure/bsecure-payments/license)](//packagist.org/packages/bsecure/bsecure-payments)
[![Build Status](https://scrutinizer-ci.com/g/bSecureCheckout/bsecure-payments-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bSecureCheckout/bsecure-payments-php/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/bSecureCheckout/bsecure-payments-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bSecureCheckout/bsecure-payments-php/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bSecureCheckout/bsecure-payments-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bSecureCheckout/bsecure-payments-php/?branch=master)


bSecure Payments 
=========================
bSecure Payments is a library that allows you to securely process your payments. This plugin instantly creates a form that adheres to PCI, HIPAA, GDPR, or CCPA security requirements.\
It is built for _desktop_, _tablet_, and _mobile devices_ and is continuously tested and updated to offer a frictionless payment experience for your e-commerce store.


### About bSecure Payment Plugin

This Payment Gateway Integration Guide  is a technical integration document for merchants to integrate with bSecure Payment Plugin allowing their customers to perform e-commerce transactions over the internet.\
It guides merchants on how to use various functionality of the bSecure. The Merchant can enable credit card payments over their e-commerce website with this integration:

### Who Should Read This Guide

The document is intended for application developers and business analysts of merchants to allow them to integrate effectively with the bSecure Payment Plugin.

### Merchant Setup Process

In order to process online payments using the bSecure Payment Plugin, the merchant needs to be registered on bSecure [Builder Portal](https://builder.bsecure.pk/).  \
The below process assumes that the merchant has been registered and all the parameters related to the merchant have been configured.\
Once merchant has signed up for bSecure Builder Portal and get its payment gateway configured, the merchant will be in a
position to perform test transaction using the sample code provided. Once the sample transaction has been successfully processed it
indicates that all the required systems have been configured correctly and the merchant is ready to go.

#### Getting Your Credentials

1. Go to [Builder Portal](https://builder.bsecure.pk/)
2. [App Integration](https://builder.bsecure.pk/integration-sandbox) >> Sandbox / Live
3. Copy **Client Id** from App Integration tab and save it in a secure file.
4. Copy **Client Secret** from App Integration tab and save it in a secure file.
5. Copy **Store Slug** from App Integration tab and save it in a secure file.
6. Get **Merchant Id** from [Builder Portal](https://builder.bsecure.pk/)

### Installation
You can install the package via **composer**

`` composer require bsecure/bsecure-payments``

**Prerequisites** 

>PHP 7.2.5 and above

**Dependencies**

>"guzzlehttp/guzzle": "^7.2"

## Usage

### Configuration

## bSecure Payments

Add provider for bSecure payments in app.php

`` bSecure\Payments\PaymentServiceProvider::class ``

Add alias

`` 'BsecurePayments' => bSecure\Payments\BsecurePayments::class ``


#### Publish the language file.
  ``php artisan vendor:publish --provider="bSecure\Payments\PaymentServiceProvider"``

It will create a vendor/bSecure folder inside resources/lang folder. If you want to customize the error messages your can overwrite the file.

#### Publish the configuration file
  ``php artisan vendor:publish --provider="bSecure\Payments\PaymentServiceProvider" --tag="config"``

A file (bSecure.php) will be placed in config folder.

```php
return [
    'client_id' => env('BSECURE_CLIENT_ID', ''),
    'integration_type' => env('BSECURE_INTEGRATION_TYPE','sandbox'), //use 'production' for live orders and 'sandbox' for testing orders. When left empty or `null` the sandbox environment will be used
    'store_slug' => env('BSECURE_STORE_SLUG'),   //If store id is not mentioned your orders will be marked against your default store
    'merchant_id' => env('BSECURE_MERCHANT_ID'),   //If store id is not mentioned your orders will be marked against your default store
];
```

#### **a) Setting up a transaction:**

The bSecure Payment Plugin will receive an HTTP POST request from the merchant website which will contain the merchant authentication
details along with the transaction details. The Payment Plugin will inquire the required details from the customer and process transaction:

##### Transaction Details
```Php
[
    'order_id' => '',
    'transaction_dt' => Carbon::now()->toString(),
    'sub_total_amt' => '',
    'discount_amt' => '',
    'total_amt' => '',
    'redirect_url' => '',
],
```

##### Customer Details
```Php
[
    'name' => '',
    'country_code' => '',
    'phone_number' => '',
    'email' => '',
],
```

##### Customer Address Details
```Php
[
    'country' => '',
    'province' => '',
    'city' => '',
    'area' => '',
    'address' => '',
],
```

### Examples

#### Create Transaction
```php
use bSecure\Payments\BsecurePayments;
```

```php
$order = new BsecurePayments();

$order->setTransactionDetails($transactionDetails);
$order->setCustomer($customer);
$order->setCustomerAddress($customerAddress);

return $order->createOrder();
return $result;
```

In response createOrder(), will return order expiry, checkout_url, order_reference and merchant_order_id.
```
array (
  'expiry' => '2020-11-27 10:55:14',
  'checkout_url' => 'bSecure-checkout-url',
  'store_url' => 'store-url',
  'merchant_store_name' => 'your-store-name',
  'order_reference' => 'bsecure-reference',
  'merchant_order_id' => 'your-order-id'
) 
```
>If you are using a web-solution then simply redirect the user to checkout_url
```
if(!empty($result['checkout_url']))
return redirect($result['checkout_url']); 
```
>If you have Android or IOS SDK then initialize your native app's webview with 'checkout_url' and provide order_reference to it for url matching
```
if(!empty($result['order_reference']))
return $result['order_reference']; 
```

Once transaction is created you will be able to process your checkout.



#### Callback on Order Placement
Once the order is successfully placed, bSecure will redirect the customer to the url you mentioned in “Checkout
redirect url” in your [environment settings](https://builder.bsecure.pk/) in Partners Portal, with one additional param “order_ref” in the query
string.

#### Order Updates
By using order_ref you received in the "**[Callback on Order Placement](#callback-on-order-placement)**" you can call below method to get order details.

```php
use bSecure\Payments\BsecurePayments;
```

```php
$order_ref = $order->order_ref;

$orderStatusUpdate = new BsecurePayments();
$result =  $orderStatusUpdate->orderStatusUpdates($order_ref);
return $result;
```

#### Order Status Change Webhook
Whenever there is any change in order status or payment status, bSecure will send you an update with complete
order details (contents will be the same as response of *[Order Updates](https://github.com/bSecureCheckout/bsecure-laravel/tree/master#order-updates)*) on the URL you mentioned in *Checkout Order Status webhook* in your environment settings in Partners Portal. (your webhook must be able to accept POST request).


In response of "**[Callback on Order Placement](#callback-on-order-placement)**" and "**[Order Updates](#order-updates)**" you will recieve complete details of your order in below mentioned format:

```
{
  "status": 200,
  "message": [
    "Request Successful"
  ],
  "body": {
    "merchant_order_id": "your-order-id",
    "order_ref": "bsecure-order-reference",
    "order_type": "App/Manual/Payment gateway",
    "placement_status": "6",
    "payment_status": null,
    "customer": {
      "name": "",
      "email": "",
      "country_code": "",
      "phone_number": "",
      "gender": "",
      "dob": ""
    },
    "payment_method": {
      "id": 5,
      "name": "Debit/Credit Card"
    },
    "card_details": {
      "card_type": null,
      "card_number": null,
      "card_expire": null,
      "card_name": null
    },
    "delivery_address": {
      "country": "",
      "province": "",
      "city": "",
      "area": "",
      "address": "",
      "lat": "",
      "long": ""
    },
    "shipment_method": {
      "id": 0,
      "name": "",
      "description": "",
      "cost": 0
    },
    "items": [
      {
        "product_id": "",
        "product_name": "",
        "product_sku": "",
        "product_qty": ""
      },
    ],
    "created_at": "",
    "time_zone": "",
    "summary": {
      "total_amount": "",
      "sub_total_amount": "",
      "discount_amount": "",
      "shipment_cost": "",
      "merchant_service_charges": ""
    }
  },
  "exception": null
}

```

### Managing Orders and Payments

#### Payment Status

| ID  | Value     | Description                                                                    |
| :-: | :-------- | :----------------------------------------------------------------------------- |
|  0  | Pending   | Order placed. But payment is awaiting for fulfillment by the customer.         |
|  1  | Completed | Order fulfilled, placed and payment has also been received.                    |
|  2  | Failed    | Payment failed or was declined or maximum attempt for payment request reached. |

#### Order Status

| ID  | Value                 | Description                                                                                                                        |
| :-: | :-------------------- | :--------------------------------------------------------------------------------------------------------------------------------  |
|  1  | Created               | Order created by merchant	                                                                                                       |
|  2  | Initiated             | Customer landed on bSecure checkout URL. Order is awaiting fulfillment.                                                            |
|  3  | Placed                | Customer successfully placed the order                                                                                             |
|  4  | Awaiting Confirmation | Customer successfully placed the order, but is awaiting for customer confirmation to authenticate the transaction.                 |
|  5  | Canceled              | Customer cancelled the order at the time of confirmation.                                                                          |
|  6  | Expired               | Order not processed within expected time frame. timeframe                                                                          |
|  7  | Failed                | Max payment attempt reached                                                                                                        |
|  8  | Awaiting Payment      | Customer successfully placed the order, but is payment is due or awaiting payment                                                  |



### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Contributions

**"bSecure – Your Universal Checkout"** is open source software.
