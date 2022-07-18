<?php

return [
    'client_id' => env('BSECURE_CLIENT_ID', ''),
    'integration_type' => env('BSECURE_INTEGRATION_TYPE','sandbox'), //use 'production' for live orders and 'sandbox' for testing orders. When left empty or `null` the sandbox environment will be used
    'store_slug' => env('BSECURE_STORE_SLUG'),   //If store id is not mentioned your orders will be marked against your default store
    'merchant_id' => env('BSECURE_MERCHANT_ID'),   //If store id is not mentioned your orders will be marked against your default store
];
