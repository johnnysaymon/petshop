<?php

declare(strict_types=1);

namespace App\Domain\Entity\Client;

use InvalidArgumentException;
use Stringable;

final class ClientName implements Stringable
{
    private string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (! self::isValid($value)) {
            throw new InvalidArgumentException("invalid-client-name", 100);
        }

        $this->value = $value;
    }

    public static function isValid(string $value): bool
    {
        if (empty($value)) {
            return false;
        }

        if (strlen($value) < 2) {
            return false;
        }

        if (strlen($value) > 100) {
            return false;
        }

        return true;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
