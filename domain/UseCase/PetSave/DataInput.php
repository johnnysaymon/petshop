<?php

declare(strict_types=1);

namespace App\Domain\UseCase\PetSave;

class DataInput
{
    public function __construct(
        public ?string $id,
        public ?string $species,
        public ?string $breedName,
        public ?string $name,
        public ?string $age,
        public ?string $ownerId,
    ) {
    }

    public static function createFromArray(array $data): DataInput
    {
        return new DataInput(
            id: $data['id'] ?? null,
            species: $data['species'] ?? null,
            breedName: $data['breedName'] ?? null,
            name: $data['name'] ?? null,
            age: $data['age'] ?? null,
            ownerId: $data['ownerId'] ?? null,
        );
    }
}
