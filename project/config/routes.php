<?php

declare(strict_types=1);

use Viktorprogger\TelegramBot\Infrastructure\Web\Controller\TelegramHookController;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\DataResponse\Middleware\FormatDataResponseAsJson;
use Yiisoft\Request\Body\RequestBodyParser;
use Yiisoft\Router\Route;
use Yiisoft\Yii\Sentry\SentryMiddleware;

return [
    Route::post('/telegram/hook')
        ->middleware(SentryMiddleware::class)
        ->middleware(RequestBodyParser::class)
        ->middleware(FormatDataResponseAsJson::class)
        ->action([TelegramHookController::class, 'hook']),
];
