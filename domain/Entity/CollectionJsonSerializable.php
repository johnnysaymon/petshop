<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use JsonSerializable;

abstract class CollectionJsonSerializable extends Collection implements JsonSerializable
{
    public function jsonSerialize(): array
    {
        return $this->getItemList();
    }
}
