<?php

namespace Bot\Infrastructure;

use Monolog\LogRecord;

class RequestIdLogProcessor
{
    public function __construct(private readonly RequestId $requestId)
    {
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        /** @var array $context */
        $context = $record['context'] ?? [];
        $context += ['request_id' => $this->requestId->getValue()];

        return $record->with(...['context' => $context]);
    }
}
