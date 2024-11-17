<?php

namespace App\Helper;

class ApiLogger
{
    private static array $apiLog = [];

    public static function startApiLog(): void
    {
        self::$apiLog = [
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'ip' => request()->header('x-forwarded-for') ?? '',
            'status' => 0,
            'start_time' => microtime(true),
            'total_time' => 0,
            'user_agent' => request()->header('user-agent', ''),
            'phone' => request()->header('phone', ''),
            'req_payload' => config('constants.api_logging.is_request_payload_log_enabled') ? request()->post() : [],
        ];
    }

    public static function endApiLog($response = null): array
    {
        self::$apiLog = array_merge(self::$apiLog, [
            'total_time' => self::getMicroTimeDiffInMs(self::$apiLog['start_time'] ?? 0),
            'res_payload' => config('constants.api_logging.is_response_payload_log_enabled') ? $response->getContent() : [],
            'status' => $response ? $response->getStatusCode() : 0,
        ]);

        return self::$apiLog;
    }

    public static function getMicroTimeDiffInMs($microTime = 0): float
    {
        if (!$microTime) {
            return 0;
        }

        return round((microtime(true) - $microTime) * 1000, 2);
    }
}
