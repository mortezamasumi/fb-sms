<?php

return [
    'operator' => env('SMS_CHANNEL_OPERATOR', '\Mortezamasumi\Sms\Operators\Fake'),
    'api_key' => env('SMS_CHANNEL_API_KEY', 'key'),
    'gateway' => env('SMS_CHANNEL_GATEWAY', 'gateway'),
    'receiver' => env('SMS_CHANNEL_RECEIVER', null),
    'prepend_text' => env('SMS_CHANNEL_PREPEND_TEXT', ''),
    'append_text' => env('SMS_CHANNEL_APPEND_TEXT', '\n\n\n لغو ۱۱'),
];
