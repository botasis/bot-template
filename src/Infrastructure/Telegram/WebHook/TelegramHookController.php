<?php

declare(strict_types=1);

namespace Bot\Infrastructure\Telegram\WebHook;

use Botasis\Runtime\Application;
use Botasis\Runtime\Update\UpdateFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Yii\Queue\Message\Message;
use Yiisoft\Yii\Queue\Queue;

final readonly class TelegramHookController
{
    public function __construct(
        private DataResponseFactoryInterface $responseFactory,
        private Application $application,
        private UpdateFactory $updateFactory,
    ) {
    }

    public function hook(ServerRequestInterface $request): ResponseInterface
    {
        /** @psalm-suppress PossiblyInvalidArgument */
        $Update = $this->updateFactory->create($request->getParsedBody());
        $this->application->handle($Update);

        return $this->responseFactory->createResponse();
    }

    public function hookQueued(ServerRequestInterface $request, Queue $queue): ResponseInterface
    {
        $message = new Message(TelegramHookHandler::NAME, $request->getParsedBody());
        $queue->push($message);

        return $this->responseFactory->createResponse();
    }
}
