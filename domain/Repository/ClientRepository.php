<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Client\ClientCollection;
use Exception;

interface ClientRepository
{
    /**
     * @throws Exception
     */
    public function findAll(): ClientCollection;

    /**
     * @throws Exception
     */
    public function findById(string $id): Client;

    /**
     * @throws Exception
     */
    public function findByIdList(string ...$id): ClientCollection;

    /**
     * @throws Exception
     */
    public function store(Client $client): void;
}
