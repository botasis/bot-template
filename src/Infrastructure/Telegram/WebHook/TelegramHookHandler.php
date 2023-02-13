<?php

declare(strict_types=1);

namespace Bot\Infrastructure\Telegram\WebHook;

use Viktorprogger\TelegramBot\Domain\Entity\Request\TelegramRequestFactory;
use Viktorprogger\TelegramBot\Domain\UpdateRuntime\Application;
use Yiisoft\Yii\Queue\Message\MessageInterface;

final class TelegramHookHandler
{
    public const NAME = 'telegram-hook';

    public function __construct(
        private readonly Application $application,
        private readonly TelegramRequestFactory $requestFactory,
    ) {
    }

    public function __invoke(MessageInterface $message): void
    {
        /** @var array $update */
        $update = $message->getData();
        $telegramRequest = $this->requestFactory->create($update);
        $this->application->handle($telegramRequest);
    }
}
