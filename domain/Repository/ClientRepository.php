<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Client\ClientCollection;
use Exception;

interface ClientRepository
{
    public function beginTransaction(): void;

    public function commitTransaction(): void;

    public function rollBackTransaction(): void;

    /**
     * @throws Exception
     */
    public function delete(string $id): void;

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

    /**
     * @throws Exception
     */
    public function update(Client $client): void;
}
