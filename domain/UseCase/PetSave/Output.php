<?php

namespace App\Domain\UseCase\PetSave;

abstract class Output
{
    public string $errorAgeCode = '';
    public string $errorBreedNameCode = '';
    public string $errorNameCode = '';
    public string $errorOwnerCode = '';
    public string $errorSpeciesCode = '';

    public function status(): bool
    {
        return $this->statusAge()
            && $this->statusBreedName()
            && $this->statusName()
            && $this->statusOwner()
            && $this->statusSpecies();
    }

    public function statusAge(): bool
    {
        return empty($this->errorAgeCode);
    }

    public function statusBreedName(): bool
    {
        return empty($this->errorBreedNameCode);
    }

    public function statusName(): bool
    {
        return empty($this->errorNameCode);
    }

    public function statusOwner(): bool
    {
        return empty($this->errorOwnerCode);
    }

    public function statusSpecies(): bool
    {
        return empty($this->errorSpeciesCode);
    }
}
