<?php

namespace App\Helper;

use Monolog\Formatter\FormatterInterface;
use Monolog\LogRecord;

class LogFormatter implements FormatterInterface
{
    public function format(LogRecord $record): string
    {
        $data = [
            'datetime' => $record->datetime->format('Y-m-d H:i:s.u'),
            'channel' => $record->channel . '.' . $record->level->getName(),
            'source' => $record->context['source'] ?? '',
            'session_id' => uniqid('log_', true) . '_' . mt_rand(1000000, 9999999),
            'message' => $record->message ?? '',
            'context' => $record->context['context'] ?? [],
        ];

        return json_encode($data, JSON_UNESCAPED_SLASHES) . PHP_EOL;
    }

    public function formatBatch(array $records): string
    {
        return implode("\n", array_map([$this, 'format'], $records));
    }
}
