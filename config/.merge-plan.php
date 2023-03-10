<?php

declare(strict_types=1);

// Do not edit. Content will be replaced.
return [
    '/' => [
        'common' => [
            'botasis/runtime' => [
                'config/common.php',
            ],
            'botasis/telegram-client' => [
                'config/common.php',
            ],
            '/' => [
                'common.php',
            ],
        ],
        'params' => [
            'botasis/runtime' => [
                'config/params.php',
            ],
            'yiisoft/data-response' => [
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
            'botasis/telegram-client' => [
                'config/params.php',
            ],
            'yiisoft/aliases' => [
                'config/params.php',
            ],
            'yiisoft/validator' => [
                'config/params.php',
            ],
            'yiisoft/yii-console' => [
                'config/params.php',
            ],
            'yiisoft/yii-queue' => [
                'config/params.php',
            ],
            'yiisoft/log-target-file' => [
                'config/params.php',
            ],
            'yiisoft/translator' => [
                'config/params.php',
            ],
            '/' => [
                'params.php',
            ],
        ],
        'di' => [
            'yiisoft/cache' => [
                'config/di.php',
            ],
            'yiisoft/router-fastroute' => [
                'config/di.php',
            ],
            'yiisoft/yii-cycle' => [
                'config/di.php',
            ],
            'yiisoft/yii-queue-amqp' => [
                'config/di.php',
            ],
            'yiisoft/yii-sentry' => [
                'config/di.php',
            ],
            'yiisoft/aliases' => [
                'config/di.php',
            ],
            'yiisoft/router' => [
                'config/di.php',
            ],
            'yiisoft/validator' => [
                'config/di.php',
            ],
            'yiisoft/yii-queue' => [
                'config/di.php',
            ],
            'yiisoft/log-target-file' => [
                'config/di.php',
            ],
            'yiisoft/translator' => [
                'config/di.php',
            ],
            'yiisoft/yii-event' => [
                'config/di.php',
            ],
        ],
        'di-web' => [
            'yiisoft/data-response' => [
                'config/di-web.php',
            ],
            'yiisoft/router-fastroute' => [
                'config/di-web.php',
            ],
            'yiisoft/error-handler' => [
                'config/di-web.php',
            ],
            'yiisoft/yii-event' => [
                'config/di-web.php',
            ],
        ],
        'di-console' => [
            'yiisoft/yii-cycle' => [
                'config/di-console.php',
            ],
            'yiisoft/yii-console' => [
                'config/di-console.php',
            ],
            'yiisoft/yii-event' => [
                'config/di-console.php',
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
            'yiisoft/log' => [
                'config/events-console.php',
            ],
        ],
        'di-delegates' => [
            'yiisoft/yii-cycle' => [
                'config/di-delegates.php',
            ],
        ],
        'bootstrap' => [
            'yiisoft/yii-sentry' => [
                'config/bootstrap.php',
            ],
        ],
        'events-web' => [
            'yiisoft/log' => [
                'config/events-web.php',
            ],
        ],
        'web' => [
            '/' => [
                '$common',
                'web.php',
            ],
        ],
        'console' => [
            '/' => [
                '$common',
                'console.php',
            ],
        ],
        'routes' => [
            '/' => [
                'routes.php',
            ],
        ],
        'events' => [
            '/' => [
                'events.php',
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
