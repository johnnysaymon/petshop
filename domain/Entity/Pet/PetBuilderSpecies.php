<?php

namespace App\Domain\Entity\Pet;

use App\Domain\Entity\Client\Client;
use Exception;

abstract class PetBuilderSpecies
{
    protected int $age = 0;
    protected string $breedName = '';
    protected string $id = '';
    protected string $name = '';
    protected Client $owner;
    protected string $species = '';

    /**
     * @throws Exception
     */
    public abstract function build(): Pet;

    public function setAge(int $age): self
    {
        $this->age = $age;
        return $this;
    }

    public function setBreedName(string $breedName): self
    {
        $this->breedName = $breedName;
        return $this;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setOwner(Client $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function setSpecies(string $species): void
    {
        $this->species = $species;
    }
}
