<?php

declare(strict_types=1);

namespace Bot\Infrastructure\Telegram\WebHook;

use Botasis\Runtime\Application;
use Botasis\Runtime\Update\UpdateFactory;
use Yiisoft\Yii\Queue\Message\MessageInterface;

final class TelegramHookHandler
{
    public const NAME = 'telegram-hook';

    public function __construct(
        private readonly Application $application,
        private readonly UpdateFactory $updateFactory,
    ) {
    }

    public function __invoke(MessageInterface $message): void
    {
        /** @var array $update */
        $update = $message->getData();
        $Update = $this->updateFactory->create($update);
        $this->application->handle($Update);
    }
}
