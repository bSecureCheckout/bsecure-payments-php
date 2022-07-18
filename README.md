[![Latest Version on Packagist](https://img.shields.io/packagist/v/bsecure/bsecure-laravel.svg?style=flat-square)](https://packagist.org/packages/bsecure/bsecure-laravel)
[![Latest Stable Version](https://poser.pugx.org/bsecure/bsecure-laravel/v)](//packagist.org/packages/bsecure/bsecure-laravel) 
[![Total Downloads](https://img.shields.io/packagist/dt/bsecure/bsecure-laravel.svg?style=flat-square)](https://packagist.org/packages/bsecure/bsecure-laravel)
[![License](https://poser.pugx.org/bsecure/bsecure-laravel/license)](//packagist.org/packages/bsecure/bsecure-laravel)
[![Build Status](https://scrutinizer-ci.com/g/bSecureCheckout/bsecure-laravel/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bSecureCheckout/bsecure-laravel/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/bSecureCheckout/bsecure-laravel/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bSecureCheckout/bsecure-laravel/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bSecureCheckout/bsecure-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bSecureCheckout/bsecure-laravel/?branch=master)

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

### Installation
You can install the package via **composer**

`` composer require bSecure/bsecure-payment-plugin-test``

**Prerequisites** 

>PHP 7.2.5 and above

**Dependencies**

>"guzzlehttp/guzzle": "^7.2"

## Usage

### Configuration

#### **a) Setting up a transaction:**

The bSecure Payment Plugin will receive an HTTP POST request from the merchant website which will contain the merchant authentication
details along with the transaction details. The Payment Plugin will inquire the required details from the customer and process transaction:

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
  'environment' => env('BSECURE_INTEGRATION_TYPE'),
  'store_id' => env('BSECURE_STORE_SLUG'),
];
```

### Examples

#### Create Payment Transaction

The bSecure Payment Plugin will receive an HTTP POST request from the merchant website which will contain the merchant authentication
details along with the transaction details. The Payment Plugin will inquire the required details from the customer and process transaction:

```JavaScript
bSecurePaymentTransactionParameters.__00trid__ = '';
bSecurePaymentTransactionParameters.__01curr__ = '';
bSecurePaymentTransactionParameters.__02trdt__ = '';
bSecurePaymentTransactionParameters.__03stamt__ = '';
bSecurePaymentTransactionParameters.__04damt__ = '';
bSecurePaymentTransactionParameters.__05tamt__ = '';
bSecurePaymentTransactionParameters.__06cname__ = '';
bSecurePaymentTransactionParameters.__07ccc__ = '';
bSecurePaymentTransactionParameters.__08cphn__ = '';
bSecurePaymentTransactionParameters.__09cemail__ = '';
bSecurePaymentTransactionParameters.__10ccc__ = '';
bSecurePaymentTransactionParameters.__11cstate__ = '';
bSecurePaymentTransactionParameters.__12ccity__ = '';
bSecurePaymentTransactionParameters.__13carea__ = '';
bSecurePaymentTransactionParameters.__14cfadd__ = '';
bSecurePaymentTransactionParameters.__15mid__ = '';
bSecurePaymentTransactionParameters.__16stid__ = '';
bSecurePaymentTransactionParameters.__17seh__ = '';
bSecurePaymentTransactionParameters.__18ver__ = '';
bSecurePaymentTransactionParameters.__19lan__ = '';
bSecurePaymentTransactionParameters.__20red__ = '';
bSecurePaymentTransactionParameters.__21cenv__ = '';
```

#### Glossary

| Key             | Property                    | Type         | Default            | Description        |
| :---------:     | :--------                   | :----------- | :--------          | :----------------  |
|  `__00trid__`   | Order id                    | string       | required           | A unique value created by the merchant to identify the transaction.  |
|  `__01curr__`   | currency                    | string       | 'PKR'              | Currency of Transaction amount. It has a fixed value of **_PKR_**      |   
|  `__02trdt__`   | Transaction date time       | string       | required           |  Merchant provided date and time of transaction. The format of date time should be _yyyyMMddHHmmss_. |
|  `__03stamt__`  | Subtotal amount             | string       | required           | The transaction subtotal amount amount.      |
|  `__04damt__`   | Discount amount             | string       | required           | The transaction discount amount.      |
|  `__05tamt__`   | Total amount                | string       | required           | The transaction total amount.      |
|  `__06cname__`  | Customer name               | optional       | required         | The name of transaction customer      |
|  `__07ccc__`    | Customer country code       | string       | required           | The country code of transaction customer      |
|  `__08cphn__`   | Customer phone number       | string       | required           | The phone number of transaction customer      |
|  `__09cemail__` | Customer email address      | string       | optional           | The email address of transaction customer      |
|  `__10ccc__`    | Customer country name       | string       | required           | The country name of transaction customer. It has a fixed value of **_PK_**      |
|  `__11cstate__` | Customer state name         | string       | required           | The state name of transaction customer      |
|  `__12ccity__`  | Customer city name          | string       | required           | The city name of transaction customer      |
|  `__13carea__`  | Customer area name          | string       | required           | The area name of transaction customer      |
|  `__14cfadd__`  | Customer formatted address  | string       | required           | The formatted address of transaction customer      |
|  `__15mid__`    | Merchant id                 | string       | required           | Unique Id assigned to merchant by **bSecure Builder Portal**.      |
|  `__16stid__`   | Store slug                  | string       | required           | Unique Slug assigned to each store by **bSecure Builder Portal**.      |
|  `__17seh__`    | Client id                   | string       | required           | Used to allow the plugin .|
|  `__19lan__`    | Order Lang                  | string       | EN                 | Language of Transaction. It has a fixed value of **EN**      |
|  `__20red__`    | Redirect url                | string       | required           | The URL where merchant wants the transaction results to be shown. Once the transaction has been processed, response details will be sent over to the merchant on this URL using an HTTP POST Request.   |
|  `__21cenv__`   | Integration type            | string       | required | The transaction integration type 1: Live 2: Sandbox


#### **b) Calculating Secure hash:**

Secure Hash is used to detect whether a transaction request and response has been tampered with. The **Client Id** generated for merchant at its [App Integration](https://builder.bsecure.pk/integration-sandbox) Tab is added to the transaction message and then an SHA256 algorithm is applied to generate a secure
hash. The secure hash is then sent to the receiving entity with the
transaction message. Because the receiving entity is the only other
entity apart from transaction initiator that knows the shared secret it
recreates the same secure hash and matches it with the one in the
request message. If the secure hash matches, the receiving entity
continues processing the transaction. If it doesn’t match, it assumes that
the transaction request has been tampered with and will stop processing
the transaction and send back an error message. This is a security feature
to secure the transaction and is recommended.\
The pp_SecureHash field is used for the SHA256 secure hash of initiator’s
shared secret and the transaction request. The secure hash value is the
Hex encoded SHA256 output of the transaction request or response
fields. The order that the fields are hashed in are:

1. The Shared Secret (shared between the PG and a merchant), the
system generated value, is always first.
2. Then all transaction request fields are concatenated to the Shared
Secret in alphabetical order of the field name. The sort should be in
ascending order of the ASCII value of each field string. If one string
is an exact substring of another, the smaller string should be before
the longer string. For example, Card should come before CardNum.
3. Fields must not have any spaces or separators between them and must not
include any null terminating characters.\
``
For example, if the Shared
Secret is 0F5DD14AE2E38C7EBD8814D29CF6F6F0, and the
transaction request includes the following fields:
``

     | Parameter                | Sample Values   |
     | :---------:              | :--------:      |
     |pp_MerchantID             | 1421            |
     | pp_OrderInfo             | A48cvE28        |   
     | pp_Amount                | 2995        |   

     In ascending alphabetical order the transaction request fields inputted
     to the SHA256 hash would be:
     ``0F5DD14AE2E38C7EBD8814D29CF6F6F02995MER123A48cvE28``\
     Example of a Secure Hash Calculation
     0F5DD14AE2E38C7EBD8814D29CF6F6F02995MER123A48cvE28
     Merchant should also ensure that:
     1. UTF-8 encoding should be used to convert the input from a printable
     string to a byte array. Note that 7-bit ASCII encoding is unchanged
     for UTF-8.
     2. The hash output must be hex-encoded.

``
Note: Inorder to calculate secure hash we are using libraries named [CryptoJS](https://www.npmjs.com/package/crypto-js)
``


#### Create Order
```php
use bSecure\Payments\BsecurePayments;
```

```php
$order = new BsecurePayments();

$order->setTransactionDetails($orderId);
$order->setCustomer($customer);

$result =  $order->createOrder();
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
>If you have Android or IOS SDK then initialize your sdk and provide order_reference to it
```
if(!empty($result['order_reference']))
return $result['order_reference']; 
```
When order is created successfully on bSecure, you will be redirected to bSecure SDK or bSecure checkout app where you will process your checkout.


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
