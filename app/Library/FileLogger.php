<?php

namespace App\Library;

use Throwable;
use Illuminate\Support\Facades\Log;

class FileLogger
{
    public static function writeToLog($channel, $message, $level = 'info', $requestId = null,  $context = []): void
    {
        if ($message instanceof Throwable) {
            $message = self::formatErrorMessage($message);
        } else if (is_array($message) || is_object($message)) {
            $message = json_encode($message);
        }

        $context['phone'] = request()->header('phone', '');
        $context['path'] = request()->fullUrl();

        Log::channel('error-log')->log($level, $message, [
            'context' => $context,
            'source' => 'channel:' . strtoupper($channel),
            'request_id' => $requestId,
        ]);
    }

    public static function formatErrorMessage(Throwable $e): string
    {
        return 'Error occurred. message: ' . $e->getMessage() . '. ' .
            'file: ' . $e->getFile() . '. ' .
            'line: ' . $e->getLine();
    }
}
