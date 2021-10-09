<?php

declare(strict_types=1);

namespace App\Domain\Entity\Client;

use App\Domain\Entity\CollectionJsonSerializable;
use Exception;

final class ClientCollection extends CollectionJsonSerializable
{
    public function add(Client ...$clientList): void
    {
        array_map(fn($client) => $this->addItem($client), $clientList);
    }

    /**
     * @throws Exception
     */
    public function getById(string $id): Client
    {
        /** @var Client $client */
        foreach ($this->getItemList() as $client) {
            if ($client->getId()->getValue() === $id) {
                return $client;
            }
        }

        throw new Exception('client-collection.not-found');
    }

    public function hasById(string $id): bool
    {
        /** @var Client $client */
        foreach ($this->getItemList() as $client) {
            if ($client->getId()->getValue() === $id) {
                return true;
            }
        }

        return false;
    }
}
