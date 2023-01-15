<?php

use Psr\Log\LogLevel;
use Yiisoft\Yii\Cycle\Schema\Provider\FromConveyorSchemaProvider;
use Yiisoft\Yii\Cycle\Schema\Provider\PhpFileSchemaProvider;

return [
    'yiisoft/log-target-file' => [
        'fileTarget' => [
            'levels' => [
                LogLevel::EMERGENCY,
                LogLevel::ERROR,
                LogLevel::WARNING,
                LogLevel::INFO,
                LogLevel::NOTICE,
                LogLevel::DEBUG,
            ],
        ],
    ],
    'yiisoft/router-fastroute' => [
        'enableCache' => false,
    ],
    'yiisoft/yii-cycle' => [
        /**
         * SchemaProvider list for {@see \Yiisoft\Yii\Cycle\Schema\Provider\Support\SchemaProviderPipeline}
         * Array of classname and {@see SchemaProviderInterface} object.
         * You can configure providers if you pass classname as key and parameters as array:
         * [
         *     SimpleCacheSchemaProvider::class => [
         *         'key' => 'my-custom-cache-key'
         *     ],
         *     FromFilesSchemaProvider::class => [
         *         'files' => ['@runtime/cycle-schema.php']
         *     ],
         *     FromConveyorSchemaProvider::class => [
         *         'generators' => [
         *              Generator\SyncTables::class, // sync table changes to database
         *          ]
         *     ],
         * ]
         */
        'schema-providers' => [
            // Uncomment next line to enable schema cache
            // SimpleCacheSchemaProvider::class => ['key' => 'cycle-orm-cache-key'],
            PhpFileSchemaProvider::class => [
                'file' => '@runtime/schema.php',
                'mode' => PhpFileSchemaProvider::MODE_WRITE_ONLY,
            ],
            FromConveyorSchemaProvider::class => [
                'generators' => [
                    Cycle\Schema\Generator\SyncTables::class, // sync table changes to database
                ],
            ],
        ],
    ],
];
