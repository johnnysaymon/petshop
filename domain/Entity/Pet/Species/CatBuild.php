<?php

namespace App\Domain\Entity\Pet\Species;

use App\Domain\Entity\Pet\BreedName;
use App\Domain\Entity\Pet\PetAge;
use App\Domain\Entity\Pet\PetBuilderSpecies;
use App\Domain\Entity\Pet\PetName;
use App\Domain\Entity\Uuid;

final class CatBuild extends PetBuilderSpecies
{
    public function build(): Cat
    {
        return new Cat(
            name: new PetName($this->name),
            age: new PetAge($this->age),
            breed: new CatBreed(
                name: new BreedName($this->breedName)
            ),
            owner: $this->owner,
            id: new Uuid($this->id),
        );
    }
}
