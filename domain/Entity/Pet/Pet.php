<?php

declare(strict_types=1);

namespace App\Domain\Entity\Pet;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Uuid;
use JsonSerializable;

abstract class Pet implements JsonSerializable
{
    public function __construct(
        protected PetName $name,
        protected PetAge $age,
        protected Client $owner,
        protected Uuid $id,
    ){}

    abstract public function getSpeciesKey(): string;

    public function getAge(): PetAge
    {
        return $this->age;
    }

    public abstract function getBreed(): Breed;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): PetName
    {
        return $this->name;
    }

    public function getOwner(): Client
    {
        return $this->owner;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName()->getValue(),
            'id' => $this->getId()->getValue(),
            'age' => $this->getAge()->getValue(),
            'owner' => $this->getOwner(),
            'species' => $this->getSpeciesKey(),
            'breed' => $this->getBreed()->getName()->getValue()
        ];
    }
}
