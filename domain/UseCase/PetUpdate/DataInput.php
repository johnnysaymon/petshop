<?php

declare(strict_types=1);

namespace App\Domain\UseCase\PetUpdate;

use App\Domain\UseCase\PetSave\DataInput as DataInputSave;

final class DataInput extends DataInputSave
{
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
