<?php

declare(strict_types=1);

use Sentry\State\HubInterface;
use Sentry\Tracing\TransactionContext;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Bot\Infrastructure\RequestId;
use Yiisoft\Yii\Http\Event\AfterEmit;
use Yiisoft\Yii\Http\Event\BeforeRequest;
use Yiisoft\Yii\Sentry\SentryConsoleHandler;

return [
    ConsoleErrorEvent::class => [
        [SentryConsoleHandler::class, 'handle'],
    ],
    BeforeRequest::class => [
        static fn(RequestId $requestId) => $requestId->regenerate(),
        static fn(HubInterface $hub) => $hub->startTransaction(new TransactionContext()),
    ],
    AfterEmit::class => [
        static fn(HubInterface $hub) => $hub->getTransaction()?->finish(),
    ],
];
