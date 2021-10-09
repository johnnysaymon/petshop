<?php

declare(strict_types=1);

namespace App\Domain\UseCase\CreateClient;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Client\ClientFactory;
use App\Domain\Entity\Client\ClientName;
use App\Domain\Entity\Phone;
use App\Domain\Repository\ClientRepository;
use Exception;

final class Service
{
    public const ERROR_EMPTY = 'empty';
    public const ERROR_INVALID = 'invalid';

    private ClientRepository $clientRepository;
    private DataInput $dataInput;
    private Output $output;

    public function __construct(
        ClientRepository $clientRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->output = new Output();
    }

    public function run(DataInput $dataInput): Output
    {
        $this->dataInput = $dataInput;

        $this->validate();

        if ($this->output->status()) {
            $client = $this->createClient();
            $this->store($client);
            $this->output->id = $client->getId()->getValue();
        }

        return $this->output;
    }

    private function validate(): void
    {
        $this->validateName();
        $this->validatePhone();
    }

    private function validateName(): void
    {
        if (empty($this->dataInput->name)) {
            $this->output->errorNameCode = self::ERROR_EMPTY;
        }

        if (false === ClientName::isValid($this->dataInput->name)) {
            $this->output->errorNameCode = self::ERROR_INVALID;
        }
    }

    private function validatePhone(): void
    {
        if (empty($this->dataInput->phone)) {
            $this->output->errorPhoneCode = self::ERROR_EMPTY;
        }

        if (false === Phone::isValid($this->dataInput->phone)) {
            $this->output->errorPhoneCode = self::ERROR_INVALID;
        }
    }

    private function createClient(): Client
    {
        return ClientFactory::create(
            name: $this->dataInput->name,
            phone: $this->dataInput->phone
        );
    }

    /**
     * @throws Exception
     */
    private function store(Client $client): void
    {
        $this->clientRepository->store($client);
    }
}
