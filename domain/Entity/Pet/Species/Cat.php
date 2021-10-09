<?php

declare(strict_types=1);

namespace App\Domain\Entity\Pet\Species;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Pet\Pet;
use App\Domain\Entity\Pet\PetAge;
use App\Domain\Entity\Pet\PetName;
use App\Domain\Entity\Uuid;

final class Cat extends Pet
{
    public const SPECIES_KEY = 'cat';

    private CatBreed $breed;

    public function __construct(PetName $name, PetAge $age, CatBreed $breed, Client $owner, Uuid $id)
    {
        parent::__construct($name, $age, $owner, $id);
        $this->breed = $breed;
    }

    public function getSpeciesKey(): string
    {
        return self::SPECIES_KEY;
    }

    public function getBreed(): CatBreed
    {
        return $this->breed;
    }
}
