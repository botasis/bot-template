<?php

declare(strict_types=1);

namespace Bot\Infrastructure\Telegram\Action;

use Botasis\Client\Telegram\Entity\Message\Message;
use Botasis\Client\Telegram\Entity\Message\MessageFormat;
use Botasis\Runtime\Response\Response;
use Botasis\Runtime\Response\ResponseInterface;
use Botasis\Runtime\Update\Update;
use Botasis\Runtime\UpdateHandlerInterface;

final class HelloAction implements UpdateHandlerInterface
{
    public function handle(Update $update): ResponseInterface
    {
        $text = <<<'TXT'
            Yii3-powered bot is here!
            Read docs to get idea where to get next: <link will be here>
            TXT;

        $message = new Message(
            $text,
            MessageFormat::TEXT,
            $update->chatId,
        );

        return (new Response())->withMessage($message);
    }
}
