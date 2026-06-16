<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Allowed origins should be explicitly set per environment via the
    | CORS_ALLOWED_ORIGINS env variable. Never use '*' in production.
    |
    | Example production value: https://app.yourdomain.com
    |
    */

    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_filter(
        explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost:3000'))
    ),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type', 'Authorization', 'Accept', 'X-Requested-With'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
