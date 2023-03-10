<?php

declare(strict_types=1);

namespace Bot\Infrastructure\Telegram\Middleware;

use Botasis\Client\Telegram\Entity\Message\Message;
use Botasis\Client\Telegram\Entity\Message\MessageFormat;
use Botasis\Runtime\Response\Response;
use Botasis\Runtime\Response\ResponseInterface;
use Botasis\Runtime\Update\Update;
use Botasis\Runtime\UpdateHandlerInterface;

final class NotFoundUpdateHandler implements UpdateHandlerInterface
{
    public function handle(Update $update): ResponseInterface
    {
        $message = new Message(
            'Извини, я не понял, что ты имеешь ввиду :(',
            MessageFormat::TEXT,
            $update->chatId
        );

        return (new Response())->withMessage($message);
    }
}
