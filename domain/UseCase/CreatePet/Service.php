<?php

declare(strict_types=1);

namespace App\Domain\UseCase\CreatePet;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Pet\Pet;
use App\Domain\Entity\Pet\PetAge;
use App\Domain\Entity\Pet\PetBuilder;
use App\Domain\Entity\Pet\PetName;
use App\Domain\Repository\ClientRepository;
use App\Domain\Repository\Exception\NotFoundInRepository;
use App\Domain\Repository\PetRepository;
use Exception;

final class Service
{
    public const ERROR_EMPTY = 'empty';
    public const ERROR_INVALID = 'invalid';

    private DataInput $dataInput;
    private Output $output;
    private Client $owner;

    public function __construct(
        private PetRepository $petRepository,
        private PetBuilder $petBuilder,
        private ClientRepository $clientRepository,
    ) {
        $this->output = new Output();
    }

    /**
     * @throws Exception
     */
    public function run(DataInput $dataInput): Output
    {
        $this->dataInput = $dataInput;

        $this->validate();

        if ($this->output->status()) {
            $pet = $this->createPet();
            $this->store($pet);
            $this->output->id = $pet->getId()->getValue();
        }

        return $this->output;
    }

    /**
     * @throws Exception
     */
    private function validate(): void
    {
        $this->validateAge();
        $this->validateBreed();
        $this->validateName();
        $this->validateOwner();
    }

    private function validateAge(): void
    {
        if (empty($this->dataInput->age)) {
            $this->output->errorAgeCode = self::ERROR_EMPTY;
        }

        if (false === PetAge::isValid((int) $this->dataInput->age)) {
            $this->output->errorAgeCode = self::ERROR_INVALID;
        }
    }

    private function validateBreed(): void
    {
        if (empty($this->dataInput->breedName)) {
            $this->output->errorBreedNameCode = self::ERROR_EMPTY;
        }

        if (false === PetAge::isValid((int) $this->dataInput->age)) {
            $this->output->errorBreedNameCode = self::ERROR_INVALID;
        }
    }

    private function validateName(): void
    {
        if (empty($this->dataInput->name)) {
            $this->output->errorNameCode = self::ERROR_EMPTY;
            return;
        }

        if (false === PetName::isValid($this->dataInput->name)) {
            $this->output->errorNameCode = self::ERROR_INVALID;
            return;
        }
    }

    /**
     * @throws Exception
     */
    private function validateOwner(): void
    {
        if (empty($this->dataInput->ownerId)) {
            $this->output->errorOwnerCode = self::ERROR_EMPTY;
            return;
        }

        try {
            $this->owner = $this->clientRepository->findById($this->dataInput->ownerId);
        } catch (NotFoundInRepository) {
            $this->output->errorOwnerCode = self::ERROR_INVALID;
        }
    }

    /**
     * @throws Exception
     */
    private function createPet(): Pet
    {
        return $this->petBuilder->build(
            species: $this->dataInput->species,
            breedName: $this->dataInput->breedName,
            name: $this->dataInput->name,
            age: (int) $this->dataInput->age,
            owner: $this->owner,
            id: null
        );
    }

    /**
     * @throws Exception
     */
    private function store(Pet $pet): void
    {
        $this->petRepository->store($pet);
    }
}
