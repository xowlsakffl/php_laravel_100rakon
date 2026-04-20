<?php

return [
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'kakao' => [
        'client_id' => env('KAKAO_CLIENT_ID'),
        'client_secret' => env('KAKAO_CLIENT_SECRET'),
        'redirect' => env('KAKAO_REDIRECT_URI'),
    ],

    'naver' => [
        'client_id' => env('NAVER_CLIENT_ID'),
        'client_secret' => env('NAVER_CLIENT_SECRET'),
        'redirect' => env('NAVER_REDIRECT_URI'),
    ],

    'toss' => [
        'client_key' => env('TOSS_CLIENT_KEY'),
        'secret_key' => env('TOSS_SECRET_KEY'),
        'webhook_secret' => env('TOSS_WEBHOOK_SECRET'),
    ],

    'aligo' => [
        'user_id' => env('ALIGO_USER_ID'),
        'api_key' => env('ALIGO_API_KEY'),
        'sender' => env('ALIGO_SENDER'),
        'test_mode' => env('ALIGO_TEST_MODE', 'Y'),
    ],

    'shop' => [
        'admin_phone' => env('SHOP_ADMIN_PHONE'),
        'customer_center_phone' => env('SHOP_CUSTOMER_CENTER_PHONE'),
        'customer_center_email' => env('SHOP_CUSTOMER_CENTER_EMAIL'),
        'bank_account_text' => env('SHOP_BANK_ACCOUNT_TEXT', 'BANK_NAME 000-000000-00000 ACCOUNT_HOLDER'),
    ],
];
