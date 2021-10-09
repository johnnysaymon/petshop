<?php

declare(strict_types=1);

namespace App\Infra\Repository;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Client\ClientCollection;
use App\Domain\Entity\Client\ClientFactory;
use App\Domain\Repository\ClientRepository;
use App\Domain\Repository\Exception\NotFoundInRepository;
use App\Exception\Exception;
use PDO;
use PDOException;

final class ClientPdo extends RepositoryTransaction implements ClientRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function delete(string $id): void
    {
        $query = <<<SQL
            DELETE FROM `client`
            WHERE `id` = :id
            LIMIT 1;
        SQL;

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        $statement->execute();
    }

    public function findAll(): ClientCollection
    {
        $query = <<<SQL
            SELECT 
                `id`, `name`, `phone`
            FROM 
                `client`;
        SQL;

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $clientDataList = $statement->fetchAll(PDO::FETCH_OBJ);

        return $this->createCollection($clientDataList);
    }

    private function createCollection(array $clientDataList): ClientCollection
    {
        $clientCollection = new ClientCollection();

        if (empty($clientDataList)) {
            return $clientCollection;
        }

        foreach ($clientDataList as $clientData) {
            $clientCollection->add(
                $this->createClient($clientData)
            );
        }

        return $clientCollection;
    }

    private function createClient(object $clientData): Client
    {
        return ClientFactory::create(
            name: $clientData->name,
            phone: $clientData->phone,
            id: $clientData->id,
        );
    }

    public function findById(string $id): Client
    {
        $query = <<<SQL
            SELECT 
                `id`, `name`, `phone`
            FROM 
                `client`
            WHERE
                `id` = :id
            LIMIT 0,1;
        SQL;

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        $statement->execute();

        $clientData = $statement->fetch(PDO::FETCH_OBJ);

        if (! $clientData) {
            throw new NotFoundInRepository('client.not-found '. $id);
        }

        return $this->createClient($clientData);
    }

    public function findByIdList(string ...$idList): ClientCollection
    {
        if(empty($idList)) {
            return $this->createCollection([]);
        }

        $itemQuery = implode(',', array_fill(0, count($idList), '?'));

        $query = <<<SQL
            SELECT 
                `id`, `name`, `phone`
            FROM 
                `client`
            WHERE
                `id` IN ({$itemQuery});
        SQL;

        $statement = $this->pdo->prepare($query);
        $statement->execute($idList);

        $clientDataList = $statement->fetchAll(PDO::FETCH_OBJ);

        return $this->createCollection($clientDataList);
    }

    /**
     * @throws PDOException
     */
    public function store(Client $client): void
    {
        $query = <<<SQL
            INSERT INTO `client` (
                `id`, `name`, phone
            ) VALUES (
                :id,
                :name,
                :phone
            );
        SQL;

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':id', $client->getId()->getValue(), PDO::PARAM_STR);
        $statement->bindValue(':name', $client->getName()->getValue(), PDO::PARAM_STR);
        $statement->bindValue(':phone', $client->getPhone()->getValue(), PDO::PARAM_STR);

        $statement->execute();
    }

    public function update(Client $client): void
    {
        $query = <<<SQL
            UPDATE `client`
            SET
                `name` =  :name,
                `phone` = :phone
            WHERE
                `id` = :id;
        SQL;

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':id', $client->getId()->getValue(), PDO::PARAM_STR);
        $statement->bindValue(':name', $client->getName()->getValue(), PDO::PARAM_STR);
        $statement->bindValue(':phone', $client->getPhone()->getValue(), PDO::PARAM_STR);

        $statement->execute();
    }
}
