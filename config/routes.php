<?php

declare(strict_types=1);

use Bot\Infrastructure\Telegram\WebHook\TelegramHookController;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\DataResponse\Middleware\FormatDataResponseAsJson;
use Yiisoft\Request\Body\RequestBodyParser;
use Yiisoft\Router\Route;
use Yiisoft\Yii\Sentry\SentryMiddleware;

return [
    // This route is required to get SSL certificate
    Route::get('/')
        ->middleware(FormatDataResponseAsJson::class)
        ->action(static fn (DataResponseFactoryInterface $responseFactory) => $responseFactory->createResponse()),

    Route::post('/telegram/hook')
        ->middleware(SentryMiddleware::class)
        ->middleware(RequestBodyParser::class)
        ->middleware(FormatDataResponseAsJson::class)
        // Use the "hookQueued" method to sent all the webhooks to a queue instead of direct processing
        ->action([TelegramHookController::class, 'hook']),
];
