<?php

declare(strict_types=1);

namespace App\Domain\UseCase\ClientUpdate;

final class DataInput
{
    public function __construct(
        public string $name = '',
        public string $phone = '',
        public string $id = '',
    ) {
    }

    public static function createFromArray(array $data): DataInput
    {
        return new DataInput(
            name: (string) ($data['name'] ?? ''),
            phone: (string) ($data['phone'] ?? ''),
            id: (string) ($data['id'] ?? ''),
        );
    }
}
