<?php

return [
    'name' => 'Twilonotify',
    'twilio_account_sid' => env('TWILIO_ACCOUNT_SID', ''),
    'twilio_auth_token' => env('TWILIO_AUTH_TOKEN', ''),
    'twilio_phone_number' => env('TWILIO_PHONE_NUMBER', '')
];
