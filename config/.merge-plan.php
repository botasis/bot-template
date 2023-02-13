<?php

declare(strict_types=1);

// Do not edit. Content will be replaced.
return [
    '/' => [
        'common' => [
            'viktorprogger/telegram-bot' => [
                'config/common.php',
            ],
            'yiisoft/cache' => [
                'config/common.php',
            ],
            'yiisoft/router-fastroute' => [
                'config/common.php',
            ],
            'yiisoft/yii-cycle' => [
                'config/common.php',
            ],
            'yiisoft/yii-queue-amqp' => [
                'config/common.php',
            ],
            'yiisoft/yii-sentry' => [
                'config/common.php',
            ],
            'yiisoft/yii-queue' => [
                'config/common.php',
            ],
            'yiisoft/aliases' => [
                'config/common.php',
            ],
            'yiisoft/router' => [
                'config/common.php',
            ],
            'yiisoft/validator' => [
                'config/common.php',
            ],
            'yiisoft/log-target-file' => [
                'config/common.php',
            ],
            'yiisoft/translator' => [
                'config/common.php',
            ],
            'yiisoft/yii-event' => [
                'config/common.php',
            ],
            '/' => [
                'common.php',
            ],
        ],
        'params' => [
            'viktorprogger/telegram-bot' => [
                'config/params.php',
            ],
            'yiisoft/router-fastroute' => [
                'config/params.php',
            ],
            'yiisoft/yii-cycle' => [
                'config/params.php',
            ],
            'yiisoft/yii-sentry' => [
                'config/params.php',
            ],
            'yiisoft/data-response' => [
                'config/params.php',
            ],
            'yiisoft/yii-queue' => [
                'config/params.php',
            ],
            'yiisoft/aliases' => [
                'config/params.php',
            ],
            'yiisoft/validator' => [
                'config/params.php',
            ],
            'yiisoft/log-target-file' => [
                'config/params.php',
            ],
            'yiisoft/yii-console' => [
                'config/params.php',
            ],
            'yiisoft/translator' => [
                'config/params.php',
            ],
            '/' => [
                'params.php',
            ],
        ],
        'web' => [
            'yiisoft/router-fastroute' => [
                'config/web.php',
            ],
            'yiisoft/data-response' => [
                'config/web.php',
            ],
            'yiisoft/error-handler' => [
                'config/web.php',
            ],
            'yiisoft/yii-event' => [
                'config/web.php',
            ],
            '/' => [
                '$common',
                'web.php',
            ],
        ],
        'console' => [
            'yiisoft/yii-cycle' => [
                'config/console.php',
            ],
            'yiisoft/yii-console' => [
                'config/console.php',
            ],
            'yiisoft/yii-event' => [
                'config/console.php',
            ],
            '/' => [
                '$common',
                'console.php',
            ],
        ],
        'events-console' => [
            'yiisoft/yii-cycle' => [
                'config/events-console.php',
            ],
            'yiisoft/yii-sentry' => [
                'config/events-console.php',
            ],
            'yiisoft/yii-console' => [
                'config/events-console.php',
            ],
            'yiisoft/yii-event' => [
                '$events',
                'config/events-console.php',
            ],
            'yiisoft/log' => [
                'config/events-console.php',
            ],
        ],
        'delegates' => [
            'yiisoft/yii-cycle' => [
                'config/delegates.php',
            ],
        ],
        'bootstrap' => [
            'yiisoft/yii-sentry' => [
                'config/bootstrap.php',
            ],
        ],
        'providers-console' => [
            'yiisoft/yii-console' => [
                'config/providers-console.php',
            ],
        ],
        'events' => [
            'yiisoft/yii-event' => [
                'config/events.php',
            ],
            '/' => [
                'events.php',
            ],
        ],
        'events-web' => [
            'yiisoft/yii-event' => [
                '$events',
                'config/events-web.php',
            ],
            'yiisoft/log' => [
                'config/events-web.php',
            ],
        ],
        'routes' => [
            '/' => [
                'routes.php',
            ],
        ],
        'delegates-console' => [
            '/' => [
                '$delegates',
            ],
        ],
        'delegates-web' => [
            '/' => [
                '$delegates',
            ],
        ],
        'providers-web' => [
            '/' => [
                'providers-web.php',
            ],
        ],
        'bootstrap-console' => [
            '/' => [
                'bootstrap-console.php',
            ],
        ],
        'bootstrap-web' => [
            '/' => [
                'bootstrap-web.php',
            ],
        ],
    ],
    'dev' => [
        'params' => [
            '/' => [
                'params-dev.php',
            ],
        ],
    ],
    'prod' => [
        'params' => [
            '/' => [
                'params-prod.php',
            ],
        ],
    ],
];
