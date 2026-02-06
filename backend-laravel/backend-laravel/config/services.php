<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'payment' => [
        'url' => getenv('PAYMENT_SERVICE_URL') ?: null,
    ],


    'postmark' => [
        'key' => getenv('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => getenv('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => getenv('AWS_ACCESS_KEY_ID'),
        'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
        'region' => getenv('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => getenv('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => getenv('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
