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
        'order_id' => null,
        'client_id' => null,
        'merchant_id' => null,
        'store_slug' => null,
        'integration_type' => null,
        'currency' => null,
        'transaction_dt' => null,
        'sub_total_amt' => null,
        'discount_amt' => null,
        'total_amt' => null,
        'redirect_url' => null,
        'customer' => null,
        'address' => null,
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
                'client_id' => 'required',
                'merchant_id' => 'required',
                'store_slug' => 'required',
                'integration_type' => 'required|boolean',
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

            $this->orderPayload['order_id'] = $details['transaction_id'];
            $this->orderPayload['client_id'] = $details['client_id'];
            $this->orderPayload['merchant_id'] = $details['merchant_id'];
            $this->orderPayload['store_slug'] = $details['store_slug'];
            $this->orderPayload['integration_type'] = $details['integration_type'];
            $this->orderPayload['currency'] = 'PKR';
            $this->orderPayload['transaction_dt'] = $details['transaction_dt'];
            $this->orderPayload['sub_total_amt'] = $details['sub_total_amt'];
            $this->orderPayload['discount_amt'] = $details['discount_amt'];
            $this->orderPayload['total_amt'] = $details['total_amt'];
            $this->orderPayload['redirect_url'] = $details['redirect_url'];
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
            $this->orderPayload['address'] = $customer;
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

            $validator = new Validator;
            $validation = $validator->make($this->orderPayload, [
                'order_id' => 'required',
                'client_id' => 'required',
                'merchant_id' => 'required',
                'store_slug' => 'required',
                'integration_type' => 'required',
                'currency' => 'required',
                'transaction_dt' => 'required',
                'sub_total_amt' => 'required',
                'discount_amt' => 'required',
                'total_amt' => 'required',
                'redirect_url' => 'required',
                'customer' => 'required',
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
