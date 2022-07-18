<?php

namespace bSecure\Payments;

use bSecure\Payments\Controllers\Orders\CreateOrderController;
use bSecure\Payments\Controllers\Orders\IOPNController;
use bSecure\Payments\Controllers\Orders\OrderStatusUpdateController;

use bSecure\Payments\Helpers\ApiResponseHandler;
use Illuminate\Support\Facades\Facade;
use Rakit\Validation\Validator;

class BsecurePayments extends Facade
{

    private $orderPayload = [
        'plugin_version' => null,
        'redirect_url' => null,
        'hash' => null,
        'merchant_id' => null,
        'store_id' => null,
        'customer' => null,
        'customer_address' => null,
        'order' => null,
    ];

    /*
     *  CREATE ORDER: Set Order Id
    */
    public function setTransactionDetails($details)
    {
        try {
            if(empty($details))
            {
                return ApiResponseHandler::validationError("Transaction details are required");
            }

            $validator = new Validator;
            $validation = $validator->make($details, [
                'order_id' => 'required',
                'transaction_dt' => 'required',
                'sub_total_amt' => 'required',
                'discount_amt' => 'required',
                'total_amt' => 'required',
                'redirect_url' => 'required',
            ]);
            // then validate
            $validation->validate();
            //Now check validation:
            if ($validation->fails())
            {
                return ApiResponseHandler::validationError($validation->errors());
            }

            $this->orderPayload['order'] = [
                "order_id" => $details['order_id'],
                "currency" => 'PKR',
                "sub_total_amount" => $details['sub_total_amt'],
                "discount_amount" => $details['discount_amt'],
                "total_amount" => $details['total_amt']
            ];
            $this->orderPayload['plugin_version'] = '';
            $this->orderPayload['redirect_url'] = $details['redirect_url'];
            $this->orderPayload['hash'] = 'hash';
            $this->orderPayload['merchant_id'] = config('bSecurePayments.store_id');
            $this->orderPayload['store_id'] = config('bSecurePayments.store_id');
            $this->orderPayload['hash'] = 'hash';

            return $this->orderPayload;
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /*
     *  CREATE ORDER: Set Customer Payload
    */
    public function setCustomer($customerData)
    {
        try {
            if(empty($customerData))
            {
                return ApiResponseHandler::validationError("Customer data is required");
            }

            $validator = new Validator;
            $validation = $validator->make($customerData, [
                'country_code' => 'required',
                'phone_number' => 'required',
                'name' => 'required',
                'email' => 'required',
            ]);
            // then validate
            $validation->validate();
            //Now check validation:
            if ($validation->fails())
            {
                return ApiResponseHandler::validationError($validation->errors());
            }

            $order = new CreateOrderController();
            $customer = $order->_setCustomer($customerData);
            $this->orderPayload['customer'] = $customer;
            return $this->orderPayload;
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /*
     *  CREATE ORDER: Set Customer Address Payload
    */
    public function setCustomerAddress($customerData)
    {
        try {
            if(empty($customerData))
            {
                return ApiResponseHandler::validationError("Customer address data is required");
            }

            $validator = new Validator;
            $validation = $validator->make($customerData, [
                'country_name' => 'required',
                'state_name' => 'required',
                'city_name' => 'required',
                'area_name' => 'required',
                'address' => 'required',
            ]);
            // then validate
            $validation->validate();
            //Now check validation:
            if ($validation->fails())
            {
                return ApiResponseHandler::validationError($validation->errors());
            }

            $order = new CreateOrderController();
            $customer = $order->_setCustomer($customerData);
            $this->orderPayload['customer_address'] = $customer;
            return $this->orderPayload;
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /*
     *  CREATE ORDER: Create Order using Merchant Access Token from Merchant backend server
    */
    public function createOrder()
    {
        try {
            if(empty($this->orderPayload))
            {
                return ApiResponseHandler::validationError("Transaction data is required");
            }

            $order = new CreateOrderController();
            $result = $order->create($this->orderPayload);
            return json_decode($result->getContent(), true);
//            return $result->getContent();
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
     *  INSTANT ORDER PROCESSING NOTIFICATIONS : Get order status for merchant
    */

    public function orderStatusUpdates($order_ref = null)
    {
        try {
            $customer = new IOPNController();
            $result = $customer->orderStatus($order_ref);
            return json_decode($result->getContent(), true);
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
