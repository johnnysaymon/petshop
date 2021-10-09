<?php

declare(strict_types=1);

namespace App\Domain\Entity\Client;

use App\Domain\Entity\Phone;
use App\Domain\Entity\Uuid;

final class ClientFactory
{
    public static function create(
        string $name,
        string $phone,
        ?string $id = null,
    ): Client {
        return new Client(
            new ClientName($name),
            Phone::createFromString($phone),
            new Uuid($id)
        );
    }
}
