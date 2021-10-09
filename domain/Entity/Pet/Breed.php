<?php

declare(strict_types=1);

namespace App\Domain\Entity\Pet;

abstract class Breed
{
    public function __construct(
        protected BreedName $name,
    ){}

    public function getName(): BreedName
    {
        return $this->name;
    }
}
