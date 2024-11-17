<?php

return [
    'jwt_token_expire_time' => (int) env('JWT_TOKEN_EXPIRE_TIME', 720), // in hours, default=30 days
    'jwt_refresh_token_expire_time' => (int) env('JWT_REFRESH_TOKEN_EXPIRE_TIME', 8640), // in hours, default=365 days
    'otp_validation_time' => (int) env('OTP_VALIDATION_TIME', 300), // in seconds
    'api_logging' => [
        'is_request_payload_log_enabled' => env('API_LOGGING_IS_REQUEST_PAYLOAD_LOG_ENABLED', true),
        'is_response_payload_log_enabled' => env('API_LOGGING_IS_RESPONSE_PAYLOAD_LOG_ENABLED', true),
    ],
];
