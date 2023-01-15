<?php

namespace Viktorprogger\YiisoftInform\Infrastructure;

use Monolog\LogRecord;

class RequestIdLogProcessor
{
    public function __construct(private readonly RequestId $requestId)
    {
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        $context = $record['context'] + ['request_id' => $this->requestId->getValue()];

        return $record->with(...['context' => $context]);
    }
}
