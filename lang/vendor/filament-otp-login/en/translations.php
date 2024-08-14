<?php

return [
    'otp_code' => 'OTP Code',

    'mail' => [
        'subject' => 'Online Compliance Portal - OTP Code',
        'greeting' => 'Welcome to the Online Compliance Portal!',
        'line1' => 'You are receiving this email to confirm your identity before logging in to the Online Compliance portal',
        'line2' => 'Your OTP code is: :code',
        'line3' => 'This code will be valid for :seconds seconds.',
        'line4' => 'If you think you are receiving this email by mistake, please disregard this email or you may contact us at .',
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
