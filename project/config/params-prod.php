<?php

use Yiisoft\Yii\Cycle\Schema\Provider\PhpFileSchemaProvider;
use Yiisoft\Yii\Cycle\Schema\Provider\SimpleCacheSchemaProvider;

return [
    'yiisoft/router-fastroute' => [
        'enableCache' => true,
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
            SimpleCacheSchemaProvider::class,
            PhpFileSchemaProvider::class => [
                'file' => '@runtime/schema.php',
            ],
        ],
        'migrations' => [
            'safe' => true,
        ],
    ],
];
