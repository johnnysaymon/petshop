<?php

declare(strict_types=1);

namespace App\Domain\UseCase\ClientUpdate;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Client\ClientFactory;
use App\Domain\Entity\Client\ClientName;
use App\Domain\Entity\Phone;
use App\Domain\Entity\Uuid;
use App\Domain\Repository\ClientRepository;
use Exception;

final class Service
{
    public const ERROR_EMPTY = 'empty';
    public const ERROR_INVALID = 'invalid';

    private DataInput $dataInput;
    private Output $output;
    private Client $clientCurrent;

    public function __construct(
        private ClientRepository $clientRepository
    ) {
        $this->output = new Output();
    }

    public function run(DataInput $dataInput): Output
    {
        $this->dataInput = $dataInput;

        $this->validate();

        if ($this->output->status()) {
            $this->clientCurrent = $this->clientRepository->findById($dataInput->id);
            $client = $this->createClient();
            $this->update($client);
        }

        return $this->output;
    }

    private function validate(): void
    {
        $this->validateId();
        $this->validateName();
        $this->validatePhone();
    }

    private function validateId(): void
    {
        if (empty($this->dataInput->id)) {
            $this->output->errorIdCode = self::ERROR_EMPTY;
        }

        if (false === Uuid::isValid($this->dataInput->id)) {
            $this->output->errorIdCode = self::ERROR_INVALID;
        }
    }

    private function validateName(): void
    {
        if (empty($this->dataInput->name)) {
            return;
        }

        if (false === ClientName::isValid($this->dataInput->name)) {
            $this->output->errorNameCode = self::ERROR_INVALID;
        }
    }

    private function validatePhone(): void
    {
        if (empty($this->dataInput->phone)) {
            return;
        }

        if (false === Phone::isValid($this->dataInput->phone)) {
            $this->output->errorPhoneCode = self::ERROR_INVALID;
        }
    }

    private function createClient(): Client
    {
        return ClientFactory::create(
            name: $this->dataInput->name ? $this->dataInput->name : $this->clientCurrent->getName()->getValue(),
            phone: $this->dataInput->phone ? $this->dataInput->phone : $this->clientCurrent->getPhone()->getValue(),
            id: $this->dataInput->id,
        );
    }

    /**
     * @throws Exception
     */
    private function update(Client $client): void
    {
        $this->clientRepository->update($client);
    }
}
