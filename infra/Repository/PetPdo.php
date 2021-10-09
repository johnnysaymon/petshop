<?php

declare(strict_types=1);

namespace App\Infra\Repository;

use App\Domain\Entity\Pet\Pet;
use App\Domain\Entity\Pet\PetBuilder;
use App\Domain\Entity\Pet\PetCollection;
use App\Domain\Repository\ClientRepository;
use App\Domain\Repository\PetRepository;
use Exception;
use PDO;
use PDOException;

final class PetPdo implements PetRepository
{
    public function __construct(
        private PDO $pdo,
        private ClientRepository $clientRepository
    ){ }

    public function findAll(): PetCollection
    {
        $query = <<<SQL
            SELECT 
                `id`, 
                `name`, 
                `species_key` AS `species`, 
                `breed_name` AS `breedName`, 
                `age`, 
                `owner_id` AS `ownerId`
            FROM 
                `pet`;
        SQL;

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $petDataList = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->createCollection($petDataList);
    }

    /**
     * @throws Exception
     */
    private function createCollection(array $petDataList): PetCollection
    {
        $petCollection = new PetCollection();

        if (empty($petDataList)) {
            return $petCollection;
        }

        $clientCollection = $this->clientRepository->findByIdList(
            ...array_map(fn($petData) => $petData['ownerId'], $petDataList)
        );

        foreach ($petDataList as $petData) {
            $petData['owner'] = $clientCollection->getById($petData['ownerId']);
            $petCollection->add(
                $this->createPet($petData)
            );
        }

        return $petCollection;
    }

    /**
     * @throws Exception
     */
    private function createPet(array $petData): Pet
    {
        $builder = new PetBuilder();

        return $builder->build(
            species: $petData['species'],
            breedName: $petData['breedName'],
            name: $petData['name'],
            age: (int) $petData['age'],
            owner: $petData['owner'],
            id: $petData['id']
        );
    }

    /**
     * @throws PDOException
     */
    public function store(Pet $pet): void
    {
        $sql = <<<SQL
            INSERT INTO `pet` (
                `id`, `name`, age, species_key, breed_name, owner_id
            ) VALUES (
                :id,
                :name,
                :age,
                :speciesKey,
                :breedName,
                :ownerId
            );
        SQL;

        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(':id', $pet->getId()->getValue(), PDO::PARAM_STR);
        $statement->bindValue(':name', $pet->getName()->getValue(), PDO::PARAM_STR);
        $statement->bindValue(':age', $pet->getAge()->getValue(), PDO::PARAM_INT);
        $statement->bindValue(':speciesKey', $pet->getSpeciesKey(), PDO::PARAM_STR);
        $statement->bindValue(':breedName', $pet->getBreed()->getName(), PDO::PARAM_STR);
        $statement->bindValue(':ownerId', $pet->getOwner()->getId()->getValue(), PDO::PARAM_STR);

        $statement->execute();
    }
}
