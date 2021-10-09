<?php

declare(strict_types=1);

namespace App\Domain\Entity\Pet;

use InvalidArgumentException;
use Stringable;

final class BreedName implements Stringable
{
    private string $value;

    public function __construct(string $name)
    {
        if (self::isValid($name) === false) {
            throw new InvalidArgumentException('breed-name-invalid', 203);
        }

        $this->value = $name;
    }

    public static function isValid(string $name): bool
    {
        if (strlen($name) < 2) {
            return false;
        }

        if (strlen($name) > 100) {
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
