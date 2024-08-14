<?php

return [
    'otp_code' => 'OTP Code',

    'mail' => [
        'subject' => 'OTP Code',
        'greeting' => 'Welcome! <br> You are receiving this email to confirm your identity before logging in to the Online Compliance portal',
        'line1' => 'Your OTP code is: :code',
        'line2' => 'This code will be valid for :seconds seconds.',
        'line3' => 'If you think you are receiving this email by mistake, please disregard this email or you may contact us at .',
        'salutation' => 'Best Regards, :app_name',
    ],

    'view' => [
        'time_left' => 'seconds left',
        'resend_code' => 'Resend Code',
        'verify' => 'Verify',
        'go_back' => 'Go Back',
    ],

    'notifications' => [
        'title' => 'OTP Code Sent',
        'body' => 'The verification code has been sent to your e-mail address. It will be valid in :seconds seconds.',
    ],

    'validation' => [
        'invalid_code' => 'The code you entered is invalid.',
        'expired_code' => 'The code you entered has expired.',
    ],
];
