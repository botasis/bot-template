<?php
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Monolog\LogRecord;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPLazyConnection;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;
use Sentry\ClientBuilder;
use Sentry\SentrySdk;
use Sentry\State\HubInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Viktorprogger\TelegramBot\Domain\Client\TelegramClientInterface;
use Viktorprogger\TelegramBot\Domain\UpdateRuntime\Application;
use Viktorprogger\TelegramBot\Domain\UpdateRuntime\Middleware\MiddlewareDispatcher;
use Viktorprogger\TelegramBot\Domain\UpdateRuntime\Router;
use Viktorprogger\TelegramBot\Infrastructure\Client\TelegramClientLog;
use Viktorprogger\TelegramBot\Infrastructure\Client\TelegramClientSymfony;
use Viktorprogger\TelegramBot\Infrastructure\UpdateRuntime\Middleware\RequestPersistingMiddleware;
use Viktorprogger\TelegramBot\Infrastructure\UpdateRuntime\Middleware\RouterMiddleware;
use Viktorprogger\YiisoftInform\Infrastructure\RequestIdLogProcessor;
use Viktorprogger\YiisoftInform\Infrastructure\Telegram\Middleware\NotFoundRequestHandler;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Cache\Apcu\ApcuCache;
use Yiisoft\Definitions\DynamicReference;
use Yiisoft\Definitions\Reference;
use Yiisoft\Injector\Injector;
use Yiisoft\Yii\Queue\Adapter\AdapterInterface;
use Yiisoft\Yii\Queue\AMQP\Adapter;
use Yiisoft\Yii\Queue\AMQP\MessageSerializer;
use Yiisoft\Yii\Queue\AMQP\MessageSerializerInterface;
use Yiisoft\Yii\Queue\AMQP\Settings\Queue as QueueSettings;
use Yiisoft\Yii\Queue\Queue;
use Yiisoft\Yii\Queue\QueueInterface;

/** @var array $params */

return [
    TelegramClientInterface::class => TelegramClientSymfony::class,
    TelegramClientSymfony::class => [
        '__construct()' => [
            'token' => getenv('BOT_TOKEN'),
            'logger' => Reference::to('loggerTelegram'),
        ],
    ],
    TelegramClientLog::class => ['__construct()' => ['logger' => Reference::to('loggerTelegram')]],
    HttpClientInterface::class => static fn() => HttpClient::create(),
    UuidFactoryInterface::class => UuidFactory::class,
    LoggerInterface::class => Logger::class,
    Logger::class => static function(Aliases $alias, RequestIdLogProcessor $requestIdLogProcessor) {
        return (new Logger('application'))
            ->pushProcessor(static function (LogRecord $record): LogRecord {
                if ($record->extra !== []) {
                    $context = $record->context + ['extra' => $record->extra];

                    return $record->with(...['context' => $context, 'extra' => []]);
                }

                return $record;
            })
            ->pushProcessor(new PsrLogMessageProcessor())
            ->pushProcessor(new MemoryUsageProcessor())
            ->pushProcessor(new MemoryPeakUsageProcessor())
            ->pushProcessor(new IntrospectionProcessor())
            ->pushProcessor($requestIdLogProcessor)
            ->pushHandler(
                (new RotatingFileHandler($alias->get('@runtime/logs/app.log')))
                    ->setFilenameFormat('{filename}-{date}', RotatingFileHandler::FILE_PER_MONTH)
                    ->setFormatter(new JsonFormatter())
            );
    },
    'loggerTelegram' => static fn(Logger $logger) => $logger->withName('telegram'),
    'loggerGithub' => static fn(Logger $logger) => $logger->withName('github'),
    'loggerCycle' => static fn(Logger $logger) => $logger->withName('cycle'),
    CacheInterface::class => ApcuCache::class,
    Router::class => [
        '__construct()' => ['routes' => $params['telegram routes']]
    ],
    QueueInterface::class => Queue::class,
    AdapterInterface::class => Adapter::class,
    MessageSerializerInterface::class => MessageSerializer::class,
    AbstractConnection::class => AMQPLazyConnection::class,
    AMQPLazyConnection::class => [
        '__construct()' => [
            'host' => 'amqp',
            'port' => 5672,
            'user' => getenv('AMQP_USER'),
            'password' => getenv('AMQP_PASSWORD'),
            'keepalive' => true,
        ],
    ],
    QueueSettings::class => [
        '__construct()' => ['queueName' => 'yii-queue'],
    ],
    HubInterface::class => static function (): HubInterface {
        $options = ['dsn' => getenv('SENTRY_DSN'), 'environment' => getenv('YII_ENV')];
        $client = ClientBuilder::create($options)->getClient();
        $hub = SentrySdk::init();
        $hub->bindClient($client);

        return $hub;
    },
    Application::class => [
        '__construct()' => [
            'fallbackHandler' => Reference::to(NotFoundRequestHandler::class),
            'dispatcher' => DynamicReference::to(static function (Injector $injector): MiddlewareDispatcher {
                return ($injector->make(MiddlewareDispatcher::class))
                    ->withMiddlewares(
                        [
                            RequestPersistingMiddleware::class,
                            RouterMiddleware::class,
                        ]
                    );
            }),
        ],
    ],
];
