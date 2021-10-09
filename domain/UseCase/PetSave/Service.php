<?php

declare(strict_types=1);

namespace App\Domain\UseCase\PetSave;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Pet\PetAge;
use App\Domain\Entity\Pet\PetName;
use App\Domain\Repository\ClientRepository;
use App\Domain\Repository\Exception\NotFoundInRepository;
use Exception;

abstract class Service
{
    public const ACTION_CREATE = 'create';
    public const ACTION_UPDATE = 'update';

    public const ERROR_EMPTY = 'empty';
    public const ERROR_INVALID = 'invalid';

    protected DataInput $dataInput;
    protected Output $output;
    protected ClientRepository $clientRepository;
    protected ?Client $owner;

    protected abstract function getAction(): string;

    /**
     * @throws Exception
     */
    protected function validate(): void
    {
        $this->validateAge();
        $this->validateBreed();
        $this->validateName();
        $this->validateOwner();
    }

    protected function validateAge(): void
    {
        $isEmpty = empty($this->dataInput->age);

        if ($isEmpty && $this->getAction() === self::ACTION_UPDATE) {
            return;
        }

        if ($isEmpty) {
            $this->output->errorAgeCode = self::ERROR_EMPTY;
            return;
        }

        if (false === PetAge::isValid((int) $this->dataInput->age)) {
            $this->output->errorAgeCode = self::ERROR_INVALID;
            return;
        }
    }

    protected function validateBreed(): void
    {
        $isEmpty = empty($this->dataInput->breedName);

        if ($isEmpty && $this->getAction() === self::ACTION_UPDATE) {
            return;
        }

        if ($isEmpty) {
            $this->output->errorBreedNameCode = self::ERROR_EMPTY;
            return;
        }

        if (false === PetAge::isValid((int) $this->dataInput->age)) {
            $this->output->errorBreedNameCode = self::ERROR_INVALID;
        }
    }

    protected function validateName(): void
    {
        $isEmpty = empty($this->dataInput->name);

        if ($isEmpty && $this->getAction() === self::ACTION_UPDATE) {
            return;
        }

        if ($isEmpty) {
            $this->output->errorNameCode = self::ERROR_EMPTY;
            return;
        }

        if (false === PetName::isValid($this->dataInput->name)) {
            $this->output->errorNameCode = self::ERROR_INVALID;
        }
    }

    /**
     * @throws Exception
     */
    protected function validateOwner(): void
    {
        $isEmpty = empty($this->dataInput->ownerId);

        if ($isEmpty && $this->getAction() === self::ACTION_UPDATE) {
            $this->owner = null;
            return;
        }

        if ($isEmpty) {
            $this->output->errorOwnerCode = self::ERROR_EMPTY;
            return;
        }

        try {
            $this->owner = $this->clientRepository->findById($this->dataInput->ownerId);
        } catch (NotFoundInRepository) {
            $this->output->errorOwnerCode = self::ERROR_INVALID;
        }
    }
}
