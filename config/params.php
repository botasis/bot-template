<?php

declare(strict_types=1);

use Bot\Infrastructure\Telegram\WebHook\TelegramHookHandler;
use Cycle\Database\Config\MySQL\DsnConnectionConfig;
use Cycle\Database\Config\MySQLDriverConfig;
use Psr\Log\LogLevel;
use Bot\Infrastructure\Telegram\Action\HelloAction;
use Yiisoft\Yii\Cycle\Schema\Conveyor\CompositeSchemaConveyor;

return [
    'telegram routes' => [
        [
            'rule' => static fn (string $data) => $data === '/start',
            'action' => HelloAction::class,
        ],
    ],
    'botasis/telegram-bot' => [
        'bot token' => getenv('BOT_TOKEN'),
        'errors to ignore' => [],
    ],

    'yiisoft/aliases' => [
        'aliases' => [
            '@root' => dirname(__DIR__),
            '@runtime' => '@root/runtime',
            '@vendor' => '@root/vendor'
        ],
    ],
    'yiisoft/log-target-file' => [
        'fileTarget' => [
            'file' => '@runtime/logs/app.log',
            'levels' => [
                LogLevel::EMERGENCY,
                LogLevel::ERROR,
                LogLevel::WARNING,
            ],
            'dirMode' => 0755,
            'fileMode' => null,
        ],
        'fileRotator' => [
            'maxFileSize' => 1024,
            'maxFiles' => 5,
            'fileMode' => null,
            'rotateByCopy' => null,
            'compressRotatedFiles' => false,
        ],
    ],
    'yiisoft/yii-console' => [
        'commands' => [],
    ],
    'yiisoft/yii-cycle' => [
        // DBAL config
        'dbal' => [
            // SQL query logger. Definition of Psr\Log\LoggerInterface
            'query-logger' => 'loggerCycle',
            // Default database
            'default' => 'default',
            'aliases' => [],
            'databases' => [
                'default' => ['connection' => 'default']
            ],
            'connections' => [
                'default' => new MySQLDriverConfig(
                    connection: new DsnConnectionConfig(
                        dsn: 'mysql:dbname=' . getenv('DB_NAME') . ';host=db',
                        user: getenv('DB_LOGIN'),
                        password: getenv('DB_PASSWORD'),
                    ),
                ),
            ],
        ],

        // Cycle migration config
        'migrations' => [
            'directory' => '@root/migrations',
            'namespace' => 'Viktorprogger\\YiisoftInform\\Migration',
            'table' => 'migration',
            'safe' => false,
        ],

        /**
         * Annotated/attributed entity directories list.
         * {@see \Yiisoft\Aliases\Aliases} are also supported.
         */
        'entity-paths' => [
            '@root/src',
            '@vendor/viktorprogger/telegram-bot/src/Infrastructure/Entity'
        ],

        /**
         * Config for {@see \Yiisoft\Yii\Cycle\Factory\OrmFactory}
         * Null, classname or {@see PromiseFactoryInterface} object.
         *
         * @link https://github.com/cycle/docs/blob/master/advanced/promise.md
         */
        'orm-promise-factory' => null,
        'conveyor' => CompositeSchemaConveyor::class,
    ],
    'yiisoft/yii-queue' => [
        'handlers' => [
            TelegramHookHandler::NAME => TelegramHookHandler::class,
        ],
        'channel-definitions' => [],
    ],
];
