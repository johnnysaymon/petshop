<?php

namespace App\Domain\Entity\Pet\Species;

use App\Domain\Entity\Pet\BreedName;
use App\Domain\Entity\Pet\PetAge;
use App\Domain\Entity\Pet\PetBuilderSpecies;
use App\Domain\Entity\Pet\PetName;
use App\Domain\Entity\Uuid;

final class DogBuild extends PetBuilderSpecies
{
    public function build(): Dog
    {
        return new Dog(
            name: new PetName($this->name),
            age: new PetAge($this->age),
            breed: new DogBreed(
                name: new BreedName($this->breedName)
            ),
            owner: $this->owner,
            id: new Uuid($this->id),
        );
    }
}
