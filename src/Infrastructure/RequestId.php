<?php

namespace Bot\Infrastructure;

use Ramsey\Uuid\UuidInterface;

final class RequestId
{
    private UuidInterface $uuid;

    public function __construct(private readonly UuidFactory $uuidFactory)
    {
        $this->regenerate();
    }

    public function getValue(): string
    {
        return $this->uuid->toString();
    }

    public function regenerate(): void
    {
        $this->uuid = $this->uuidFactory->create();
    }
}
