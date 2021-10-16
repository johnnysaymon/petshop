<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as UuidLib;
use Stringable;

final class Uuid implements Stringable
{
    private string $value;

    public function __construct(
        ?string $id = null,
    ) {
        if (empty($id)) {
            $id = UuidLib::uuid4()->toString();
        } elseif (self::isValid($id) === false) {
            throw new InvalidArgumentException('uuid-invalid', 2);
        }

        $this->value = $id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function isValid(string $id): bool
    {
        return UuidLib::isValid($id);
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
