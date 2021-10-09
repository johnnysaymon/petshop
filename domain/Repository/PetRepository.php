<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Pet\Pet;
use App\Domain\Entity\Pet\PetCollection;
use Exception;

interface PetRepository
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
    public function deleteAllFromOwnerId(string $ownerId);

    /**
     * @throws Exception
     */
    public function findAll(): PetCollection;

    /**
     * @throws Exception
     */
    public function findById(string $id): Pet;

    /**
     * @throws Exception
     */
    public function store(Pet $pet): void;

    /**
     * @throws Exception
     */
    public function update(Pet $pet): void;
}
