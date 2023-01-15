<?php

declare(strict_types=1);

namespace Viktorprogger\YiisoftInform\Infrastructure\Telegram\Middleware;

use Viktorprogger\TelegramBot\Domain\Client\MessageFormat;
use Viktorprogger\TelegramBot\Domain\Client\Response;
use Viktorprogger\TelegramBot\Domain\Client\ResponseInterface;
use Viktorprogger\TelegramBot\Domain\Client\TelegramMessage;
use Viktorprogger\TelegramBot\Domain\Entity\Request\TelegramRequest;
use Viktorprogger\TelegramBot\Domain\UpdateRuntime\RequestHandlerInterface;

final class NotFoundRequestHandler implements RequestHandlerInterface
{
    public function handle(TelegramRequest $request): ResponseInterface
    {
        $message = new TelegramMessage(
            'Извини, я не понял, что ты имеешь ввиду :(',
            MessageFormat::TEXT,
            $request->chatId
        );

        return (new Response())->withMessage($message);
    }
}
