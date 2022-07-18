<?php

namespace bSecure\Payments\Models;

use bSecure\Payments\Models\Merchant;
use bSecure\Payments\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    public static function createMerchantOrder($orderPayload)
    {
        try {

            $order_response = Helper::createPaymentPluginOrder($orderPayload);
            if ($order_response['error']) {
                return ['error' => true, 'message' => $order_response['body']['message'], 'exception' => $order_response['body']['exception']];
            } else {
                return $order_response;
            }
            /*
            $merchantToken = Merchant::getMerchantAccessToken();

            if ($merchantToken['error']) {
                return ['error' => true, 'message' => $merchantToken['message']];
            } else {
                $merchantAccessToken = $merchantToken['body'];
                // Call Create Order API
                $order_response = Helper::createOrder($merchantAccessToken, $orderPayload);

                if ($order_response['error']) {
                    return ['error' => true, 'message' => $order_response['body']['message'], 'exception' => $order_response['body']['exception']];
                } else {
                    return $order_response;
                }
            }
            */
        } catch (\Exception $e) {
            return ['error' => true, 'message' => trans('bSecurePayments::messages.order.failure'), 'exception' => $e->getTraceAsString()];
        }
    }


    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    public static function getOrderStatus($order_ref)
    {
        try {
            $merchantToken = Merchant::getMerchantAccessToken();

            if ($merchantToken['error']) {
                return ['error' => true, 'message' => $merchantToken['message']];
            } else {
                $merchantAccessToken = $merchantToken['body'];
                // Call Order Status Update API

                $payload = ['order_ref' => $order_ref];

                $order_response = Helper::orderStatus($merchantAccessToken, $payload);

                if ($order_response['error']) {
                    return ['error' => true, 'message' => $order_response['body']['message']];
                } else {
                    return $order_response;
                }
            }
        } catch (\Exception $e) {
            return ['error' => true, 'message' => trans('bSecurePayments::messages.order.status.failure'), 'exception' => $e->getTraceAsString()];
        }
    }
}
