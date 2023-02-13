<?php

declare(strict_types=1);

namespace Bot\Infrastructure\Entity\Request\Cycle;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use DateTimeImmutable;

/**
 * @psalm-suppress MissingConstructor
 */
#[Entity(table: 'viktorprogger_telegram_request')]
class RequestEntity
{
    #[Column(type: 'integer', primary: true)]
    public int $id;

    #[Column(type: 'timestamp')]
    public DateTimeImmutable $created_at;

    #[Column(type: 'longText')]
    public string $contents;
}
