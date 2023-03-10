<?php
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Bot\Infrastructure\RequestIdLogProcessor;
use Bot\Infrastructure\Telegram\Middleware\NotFoundUpdateHandler;
use Botasis\Client\Telegram\Client\ClientInterface;
use Botasis\Client\Telegram\Client\ClientLog;
use Botasis\Client\Telegram\Client\ClientPsr;
use Botasis\Runtime\Application;
use Botasis\Runtime\Middleware\Implementation\RouterMiddleware;
use Botasis\Runtime\Middleware\MiddlewareDispatcher;
use Botasis\Runtime\Router;
use Http\Client\Socket\Client;
use HttpSoft\Message\RequestFactory;
use HttpSoft\Message\StreamFactory;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Monolog\LogRecord;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPConnectionConfig;
use PhpAmqpLib\Connection\AMQPConnectionFactory;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;
use Sentry\ClientBuilder;
use Sentry\SentrySdk;
use Sentry\State\HubInterface;
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
    ClientInterface::class => ClientPsr::class,
    ClientPsr::class => [
        '__construct()' => [
            'token' => getenv('BOT_TOKEN'),
            'logger' => Reference::to('loggerTelegram'),
        ],
    ],
    ClientLog::class => ['__construct()' => ['logger' => Reference::to('loggerTelegram')]],

    HttpClientInterface::class => Client::class,
    StreamFactoryInterface::class => StreamFactory::class,
    RequestFactoryInterface::class => RequestFactory::class,

    UuidFactoryInterface::class => UuidFactory::class,

    LoggerInterface::class => Logger::class,
    Logger::class => static function (Aliases $alias, RequestIdLogProcessor $requestIdLogProcessor) {
        return (new Logger('application'))
            ->pushProcessor(static function (LogRecord $record) : LogRecord {
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
        '__construct()' => ['routes' => $params['telegram routes']],
    ],

    QueueInterface::class => Queue::class,
    AdapterInterface::class => Adapter::class,
    MessageSerializerInterface::class => MessageSerializer::class,
    AMQPConnectionConfig::class => [
        'setHost()' => ['amqp'],
        'setPort()' => 5672,
        'setUser()' => getenv('AMQP_USER'),
        'setPassword()' => getenv('AMQP_PASSWORD'),
        'setKeepalive()' => [true],
        'setIsLazy()' => [true],
    ],
    AbstractConnection::class => static fn(AMQPConnectionConfig $config) => AMQPConnectionFactory::create($config),
    QueueSettings::class => [
        '__construct()' => ['queueName' => 'yii-queue'],
    ],
    HubInterface::class => static function () : HubInterface {
        $options = ['dsn' => getenv('SENTRY_DSN'), 'environment' => getenv('YII_ENV')];
        $client = ClientBuilder::create($options)->getClient();
        $hub = SentrySdk::init();
        $hub->bindClient($client);

        return $hub;
    },
    Application::class => [
        '__construct()' => [
            'fallbackHandler' => Reference::to(NotFoundUpdateHandler::class),
            'dispatcher' => DynamicReference::to(static function (Injector $injector) : MiddlewareDispatcher {
                return ($injector->make(MiddlewareDispatcher::class))
                    ->withMiddlewares(
                        [
                            RouterMiddleware::class,
                        ]
                    );
            }),
        ],
    ],
];
