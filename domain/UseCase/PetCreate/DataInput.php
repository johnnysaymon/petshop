<?php

declare(strict_types=1);

namespace App\Domain\UseCase\PetCreate;

final class DataInput
{
    public function __construct(
        public string $species = '',
        public string $breedName = '',
        public string $name = '',
        public string $age = '',
        public string $ownerId = '',
    ) {
    }

    public static function createFromArray(array $data): DataInput
    {
        return new DataInput(
            species: (string) ($data['species'] ?? ''),
            breedName: (string) ($data['breedName'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            age: (string) ($data['age'] ?? ''),
            ownerId: (string) ($data['ownerId'] ?? ''),
        );
    }
}
