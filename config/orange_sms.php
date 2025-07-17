<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Orange SMS API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour l'API SMS d'Orange
    |
    */

    'base_url' => env('ORANGE_SMS_BASE_URL', 'https://api.orange.com'),
    'basic_token' => env('ORANGE_SMS_BASIC_TOKEN'),
    'default_sender_address' => env('ORANGE_SMS_DEFAULT_SENDER_ADDRESS'),
    'default_sender_name' => env('ORANGE_SMS_DEFAULT_SENDER_NAME', 'SMS 987519'),
    'timeout' => env('ORANGE_SMS_TIMEOUT', 30),
];