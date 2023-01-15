<?php

declare(strict_types=1);

namespace Viktorprogger\YiisoftInform\Infrastructure\Entity;

use InvalidArgumentException;
use Ramsey\Uuid\Exception\UnableToBuildUuidException;
use Ramsey\Uuid\UuidFactoryInterface as RamseyFactoryInterface;
use Ramsey\Uuid\UuidInterface;

final class UuidFactory
{
    public const MODE_STRING = 0x1;
    public const MODE_BYTES = 0x2;
    public const MODE_INTEGER = 0x4;
    public const MODE_ALL = 0x7;

    private RamseyFactoryInterface $uuidFactory;
    private int $generatedVersion;
    private int $mode;

    public function __construct(RamseyFactoryInterface $uuidFactory, int $generateVersion = 4, int $mode = self::MODE_ALL)
    {
        if ($generateVersion < 1 || $generateVersion > 6) {
            throw new InvalidArgumentException("Uuid version is not supported: $generateVersion");
        }

        if (($mode & self::MODE_ALL) === 0) {
            throw new InvalidArgumentException("Uuid parsing mode not supported");
        }

        $this->uuidFactory = $uuidFactory;
        $this->generatedVersion = $generateVersion;
        $this->mode = $mode;
    }

    public function create(?string $value = null): UuidInterface
    {
        if ($value === null) {
            $factoryMethod = "uuid$this->generatedVersion";
            /** @var UuidInterface $uuid */
            $uuid = $this->uuidFactory->$factoryMethod();
        } else {
            $uuid = $this->parse($value);
        }

        return $uuid;
    }

    private function parse(string $value): UuidInterface
    {
        if (($this->mode & self::MODE_BYTES) !== 0) {
            try {
                return $this->uuidFactory->fromBytes($value);
            } catch (UnableToBuildUuidException) {
            }
        }

        if (($this->mode & self::MODE_STRING) !== 0) {
            try {
                return $this->uuidFactory->fromString($value);
            } catch (UnableToBuildUuidException) {
            }
        }

        if (($this->mode & self::MODE_INTEGER) !== 0) {
            try {
                return $this->uuidFactory->fromInteger($value);
            } catch (UnableToBuildUuidException) {
            }
        }

        throw new InvalidArgumentException('The given value cannot be parsed to a correct UUID');
    }
}
