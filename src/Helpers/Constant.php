<?php

namespace bSecure\Payments\Helpers;

class Constant
{

    const PACKAGE_VERISON = "1.0.0";

    const HTTP_RESPONSE_STATUSES = [
        'success' => 200,
        'failed' => 400,
        'validationError' => 422,
        'authenticationError' => 401,
        'authorizationError' => 403,
        'serverError' => 500,
    ];

    const AUTH_SERVER_URL = 'https://api.bsecure.pk/';

    const LOGIN_REDIRECT_URL = 'https://login.bsecure.pk/auth/sso';

    const API_VERSION = 'v1';

    const API_ENDPOINTS = [
        'oauth' => Constant::API_VERSION . '/oauth/token',
        'create_order' => Constant::API_VERSION . '/order/create',
        'payment_plugin_order' => Constant::API_VERSION . '/payment-plugin/create-order',
        'order_status' => Constant::API_VERSION . '/order/status',
    ];

    const OrderStatus = [
        'created' => 1,
        'initiated' => 2,
        'placed' => 3,
        'awaiting-confirmation' => 4,
        'canceled' => 5,
        'expired' => 6,
        'failed' => 7
    ];
}
