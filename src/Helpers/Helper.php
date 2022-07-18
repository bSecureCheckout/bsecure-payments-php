<?php


namespace bSecure\Payments\Helpers;

use bSecure\Payments\Models\Merchant;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Helper
{
    public static function apiRequest($method, $url, $queryParams = [], $body = [], $headers = [], $contentType = 'json', $returnWithStatusCode = false)
    {
        $response = [];

        try {
            if (is_array($queryParams) && count($queryParams) > 0) {
                $url .= '?' . http_build_query($queryParams);
            }

            $payload = [
                $contentType => $body,
                'headers' => $headers,
                'http_errors' => false,
                'timeout' => 30,
                'connect_timeout' => 30
            ];

            $client = new Client();
            $curlResponse = $client->request($method, $url, $payload);

            if ($returnWithStatusCode) {
                $response['code'] = $curlResponse->getStatusCode();
                $response['content'] = json_decode($curlResponse->getBody()->getContents(), true);
            } else {
                $response = json_decode($curlResponse->getBody()->getContents(), true);
            }
        } catch (RequestException $e) {
//            AppException::log($e);
        } catch (Exception $e) {
//            AppException::log($e);
        } finally {
            return $response;
        }
    }

    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    static function getAccessToken($data)
    {
        $accessToken = null;

        $http = new Client();
        $authUrl = Constant::AUTH_SERVER_URL . Constant::API_ENDPOINTS['oauth'];

        $storeId =  array_key_exists('store_id',$data) ? $data['store_id'] : null;
        $clientId = !empty($storeId) ? $data['client_id'].':'.$storeId : $data['client_id'];

        $response = $http->post($authUrl, [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $clientId,
                'client_secret' => $data['client_secret'],
                'scope' => "",
            ],
        ]);

        $result = json_decode((string)$response->getBody("access_token"), true);

        if (isset($result['status']) && $result['status'] == Constant::HTTP_RESPONSE_STATUSES['success']) {

            $merchantEnvironmentCheck = config('bSecure.integration_type') ?? 'sandbox';

            if ($merchantEnvironmentCheck == $result['body']['environment']) {
                $accessToken = isset($result['body']['access_token']) ? $result['body']['access_token'] : null;
                return ['client_id' => '', 'error' => false, 'accessToken' => $accessToken];
            } else {
                return ['client_id' => '', 'error' => true, 'message' => trans('bSecurePayments::messages.client.environment.invalid')];
            }
        }
    }

    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    static function createPaymentPluginOrder($orderPayload)
    {
        $method = 'POST';

        $url = Constant::AUTH_SERVER_URL . Constant::API_ENDPOINTS['payment_plugin_order'];
        $headers = [];

        $result = Helper::apiRequest($method, $url, [], $orderPayload, $headers, 'form_params');

        if (isset($result['status']) && $result['status'] == Constant::HTTP_RESPONSE_STATUSES['success']) {
            $response = ['error' => false, 'body' => $result['body']];
        } else {
            $response = ['error' => true, 'body' => $result];
        }
        return $response;
    }



    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    static function createOrder($merchantAccessToken, $orderPayload)
    {
        $method = 'POST';

        $url = Constant::AUTH_SERVER_URL . Constant::API_ENDPOINTS['create_order'];

        $headers = ['Authorization' => 'Bearer ' . $merchantAccessToken];

        $result = Helper::apiRequest($method, $url, [], $orderPayload, $headers, 'form_params');

        if (isset($result['status']) && $result['status'] == Constant::HTTP_RESPONSE_STATUSES['success']) {
            $response = ['error' => false, 'body' => $result['body']];
        } else {
            $response = ['error' => true, 'body' => $result];
        }
        return $response;
    }


    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    static function orderStatus($merchantAccessToken, $order_ref)
    {
        $method = 'POST';

        $url = Constant::AUTH_SERVER_URL . Constant::API_ENDPOINTS['order_status'];

        $headers = ['Authorization' => 'Bearer ' . $merchantAccessToken];

        $result = Helper::apiRequest($method, $url, [], $order_ref, $headers, 'form_params');

        if (isset($result['status']) && $result['status'] == Constant::HTTP_RESPONSE_STATUSES['success']) {
            $response = ['error' => false, 'body' => $result['body']];
        } else {
            $response = ['error' => true, 'body' => $result];
        }
        return $response;
    }


    static function calculateSecureHash($payload){
        $details = [
            '__00trid__' => $payload['order']['order_id'],
            '__01curr__' => $payload['order']['currency'],
            '__02trdt__' => $payload['txn_reference'],
            '__03stamt__' => $payload['order']['sub_total_amount'],
            '__04damt__' => $payload['order']['discount_amount'],
            '__05tamt__' => $payload['order']['total_amount'],
            '__06cname__' => $payload['customer']['name'],
            '__07ccc__' => $payload['customer']['country_code'],
            '__08cphn__' => $payload['customer']['phone_number'],
            '__09cemail__' => $payload['customer']['email'],
            '__10ccc__' => $payload['customer_address']['country'],
            '__11cstate__' => $payload['customer_address']['province'],
            '__12ccity__' => $payload['customer_address']['city'],
            '__13carea__' => $payload['customer_address']['area'],
            '__14cfadd__' => $payload['customer_address']['address'],
            '__15mid__' => $payload['merchant_id'],
            '__16stid__' => $payload['store_id'],
            '__18ver__' => $payload['plugin_version'],
            '__19lan__' => 'EN',
            '__20red__' => $payload['redirect_url'],
            '__21cenv__' => $payload['env_id'],
        ];

        $salt = config('bSecurePayments.client_id');
        ksort($details);
        $signature = $salt."&";
        foreach($details as $key => $value)
        {
            $signature .= preg_replace("/\s+/", "", $value);
            if(next($details)) {
                $signature .= "&";
            }
        }
        $setSignature = hash_hmac('sha256', $signature, $salt);

        return strtoupper($setSignature);
    }


}

