<?php

declare(strict_types=1);

use Yiisoft\Config\Config;
use Yiisoft\Config\ConfigPaths;
use Yiisoft\Config\Modifier\RecursiveMerge;
use Yiisoft\Config\Modifier\RemoveFromVendor;
use Yiisoft\Config\Modifier\ReverseMerge;
use Yiisoft\Yii\Runner\RoadRunner\RoadRunnerApplicationRunner;

require_once __DIR__ . '/preload.php';

(new RoadRunnerApplicationRunner(__DIR__, $_ENV['YII_DEBUG'], $_SERVER['YII_ENV']))
    ->withConfig(
        new Config(
            new ConfigPaths(__DIR__, 'config'),
            $_SERVER['YII_ENV'],
            [
                ReverseMerge::groups('events', 'events-web', 'events-console'),
                RecursiveMerge::groups('params', 'events', 'events-web', 'events-console'),
                RemoveFromVendor::keys(['yiisoft/log-target-file', 'fileTarget', 'levels']),
            ],
        )
    )
    ->run();
