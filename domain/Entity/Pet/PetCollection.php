<?php

declare(strict_types=1);

namespace App\Domain\Entity\Pet;

use App\Domain\Entity\CollectionJsonSerializable;

final class PetCollection extends CollectionJsonSerializable
{
    public function add(Pet ...$petList): void
    {
        array_map(fn($pet) => $this->addItem($pet), $petList);
    }
}
