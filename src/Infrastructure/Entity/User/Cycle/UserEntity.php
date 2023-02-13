<?php

declare(strict_types=1);

namespace Bot\Infrastructure\Entity\User\Cycle;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(table: 'viktorprogger_telegram_user')]
class UserEntity
{
    public function __construct(
        #[Column(type: 'string', primary: true)]
        public string $id,
    ) {
    }
}
