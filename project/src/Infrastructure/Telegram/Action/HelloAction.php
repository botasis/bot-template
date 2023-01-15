<?php

declare(strict_types=1);

namespace Viktorprogger\YiisoftInform\Infrastructure\Telegram\Action;

use Viktorprogger\TelegramBot\Domain\Client\InlineKeyboardButton;
use Viktorprogger\TelegramBot\Domain\Client\MessageFormat;
use Viktorprogger\TelegramBot\Domain\Client\Response;
use Viktorprogger\TelegramBot\Domain\Client\ResponseInterface;
use Viktorprogger\TelegramBot\Domain\Client\TelegramMessage;
use Viktorprogger\TelegramBot\Domain\Client\TelegramMessageUpdate;
use Viktorprogger\TelegramBot\Domain\Entity\Request\TelegramRequest;
use Viktorprogger\TelegramBot\Domain\UpdateRuntime\RequestHandlerInterface;

final class HelloAction implements RequestHandlerInterface
{
    public function handle(TelegramRequest $request): ResponseInterface
    {
        $text = <<<'TXT'
            Yii3-powered bot is here\!
            Read docs to get idea where to get next: \<link will be here\>
            TXT;

        $message = new TelegramMessage(
            $text,
            MessageFormat::MARKDOWN,
            $request->chatId,
        );

        return (new Response())->withMessage($message);
    }
}
