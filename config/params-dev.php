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
        'schema-providers' => [
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
