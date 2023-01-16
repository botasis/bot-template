<?php

declare(strict_types=1);

use Cycle\ORM\Relation;
use Cycle\ORM\SchemaInterface as Schema;

return [
    'requestEntity' => [
        Schema::ENTITY => Viktorprogger\TelegramBot\Infrastructure\Entity\Request\Cycle\RequestEntity::class,
        Schema::MAPPER => Cycle\ORM\Mapper\Mapper::class,
        Schema::SOURCE => Cycle\ORM\Select\Source::class,
        Schema::REPOSITORY => Cycle\ORM\Select\Repository::class,
        Schema::DATABASE => 'default',
        Schema::TABLE => 'viktorprogger_telegram_request',
        Schema::PRIMARY_KEY => ['id'],
        Schema::FIND_BY_KEYS => ['id'],
        Schema::COLUMNS => [
            'id' => 'id',
            'created_at' => 'created_at',
            'contents' => 'contents',
        ],
        Schema::RELATIONS => [],
        Schema::SCOPE => null,
        Schema::TYPECAST => [
            'id' => 'int',
            'created_at' => 'datetime',
        ],
        Schema::SCHEMA => [],
        Schema::TYPECAST_HANDLER => null,
    ],
    'userEntity' => [
        Schema::ENTITY => Viktorprogger\TelegramBot\Infrastructure\Entity\User\Cycle\UserEntity::class,
        Schema::MAPPER => Cycle\ORM\Mapper\Mapper::class,
        Schema::SOURCE => Cycle\ORM\Select\Source::class,
        Schema::REPOSITORY => Cycle\ORM\Select\Repository::class,
        Schema::DATABASE => 'default',
        Schema::TABLE => 'viktorprogger_telegram_user',
        Schema::PRIMARY_KEY => ['id'],
        Schema::FIND_BY_KEYS => ['id'],
        Schema::COLUMNS => [
            'id' => 'id',
        ],
        Schema::RELATIONS => [],
        Schema::SCOPE => null,
        Schema::TYPECAST => [],
        Schema::SCHEMA => [],
        Schema::TYPECAST_HANDLER => null,
    ],
];
