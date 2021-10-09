<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Pet\Pet;
use App\Domain\Entity\Pet\PetCollection;
use Exception;

interface PetRepository
{
    /**
     * @throws Exception
     */
    public function findAll(): PetCollection;

    /**
     * @throws Exception
     */
    public function store(Pet $pet): void;
}