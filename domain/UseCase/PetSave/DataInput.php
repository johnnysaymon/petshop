<?php

declare(strict_types=1);

namespace App\Domain\UseCase\PetSave;

class DataInput
{
    public function __construct(
        public ?string $id = null,
        public ?string $species = null,
        public ?string $breedName = null,
        public ?string $name = null,
        public ?string $age = null,
        public ?string $ownerId = null,
    ) {
    }

    public static function feed(DataInput $dataInput, array $data): DataInput
    {
        isset($data['id']) && $dataInput->id = (string) $data['id'];
        isset($data['species']) && $dataInput->species = (string) $data['species'];
        isset($data['breedName']) && $dataInput->breedName = (string) $data['breedName'];
        isset($data['name']) && $dataInput->name = (string) $data['name'];
        isset($data['age']) && $dataInput->age = (string) $data['age'];
        isset($data['ownerId']) && $dataInput->ownerId = (string) $data['ownerId'];

        return $dataInput;
    }
}
