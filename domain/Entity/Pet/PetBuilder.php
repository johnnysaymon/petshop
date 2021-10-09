<?php

declare(strict_types=1);

namespace App\Domain\Entity\Pet;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Pet\Species\Cat;
use App\Domain\Entity\Pet\Species\CatBuild;
use App\Domain\Entity\Pet\Species\Dog;
use App\Domain\Entity\Pet\Species\DogBuild;
use Exception;

final class PetBuilder
{
    /**
     * @var PetBuilderSpecies[]
     */
    private array $petBuilderSpeciesList;

    public function __construct()
    {
        $this->petBuilderSpeciesList = [];
        $this->set(Dog::SPECIES_KEY, new DogBuild())
            ->set(Cat::SPECIES_KEY, new CatBuild());
    }


    public function set(string $key, PetBuilderSpecies $builder): self
    {
        $this->petBuilderSpeciesList[$key] =  $builder;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function build(
        string $species,
        string $breedName,
        string $name,
        int $age,
        Client $owner,
        ?string $id
    ): Pet
    {
        $builder = $this->getBuilderSpecies($species);

        if ($builder == null) {
            throw new Exception('pet.species-unknown');
        }

        if ($id !== null) {
            $builder->setId($id);
        }

        return $builder->setAge($age)
            ->setBreedName($breedName)
            ->setName($name)
            ->setOwner($owner)
            ->build();
    }

    private function getBuilderSpecies(string $species): ?PetBuilderSpecies
    {
        if (isset($this->petBuilderSpeciesList[$species]) === false) {
            return null;
        }

        return $this->petBuilderSpeciesList[$species];
    }
}
