<?php

return [
    'client_id' => env('BSECURE_CLIENT_ID', ''),
    'environment' => env('BSECURE_ENVIRONMENT'), //use 'production' for live orders and 'sandbox' for testing orders. When left empty or `null` the sandbox environment will be used
    'store_id' => env('BSECURE_STORE_ID'),   //If store id is not mentioned your orders will be marked against your default store
];
