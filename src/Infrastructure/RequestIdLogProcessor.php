<?php

namespace Bot\Infrastructure;

use Monolog\LogRecord;

readonly class RequestIdLogProcessor
{
    public function __construct(private RequestId $requestId)
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
