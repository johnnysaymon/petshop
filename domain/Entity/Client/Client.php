<?php

declare(strict_types=1);

namespace App\Domain\Entity\Client;

use App\Domain\Entity\Phone;
use App\Domain\Entity\Uuid;
use JsonSerializable;

final class Client implements JsonSerializable
{
    public function __construct(
        private ClientName $name,
        private Phone $phone,
        private Uuid $id,
    ) {}

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): ClientName
    {
        return $this->name;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName()->getValue(),
            'phone' => $this->getPhone()->getValue(),
            'id' => $this->getId()->getValue(),
        ];
    }
}
