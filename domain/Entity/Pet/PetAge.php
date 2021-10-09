<?php

declare(strict_types=1);

namespace App\Domain\Entity\Pet;

use InvalidArgumentException;

final class PetAge
{
    private int $value;

    public function __construct(int $age)
    {
        if (self::isValid($age) === false) {
            throw new InvalidArgumentException('pet-age-invalid', 201);
        }

        $this->value = $age;
    }

    public static function isValid(int $age): bool
    {
        if ($age < 0) {
            return false;
        }

        return true;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
