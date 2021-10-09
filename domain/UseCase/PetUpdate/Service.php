<?php

declare(strict_types=1);

namespace App\Domain\UseCase\PetUpdate;

use App\Domain\Entity\Pet\Pet;
use App\Domain\Entity\Pet\PetBuilder;
use App\Domain\Repository\ClientRepository;
use App\Domain\Repository\PetRepository;
use App\Domain\UseCase\PetSave\Service as ServiceSave;
use Exception;

final class Service extends ServiceSave
{
    private Pet $petCurrent;

    public function __construct(
        private PetRepository $petRepository,
        private PetBuilder $petBuilder,
        ClientRepository $clientRepository,
    ) {
        $this->output = new Output();
        $this->clientRepository = $clientRepository;
    }

    protected function getAction(): string
    {
        return ServiceSave::ACTION_UPDATE;
    }

    /**
     * @throws Exception
     */
    public function run(DataInput $dataInput): Output
    {
        $this->dataInput = $dataInput;

        $this->validate();

        if ($this->output->status()) {
            $this->petCurrent = $this->petRepository->findById($dataInput->id);
            $pet = $this->createPet();
            $this->update($pet);
        }

        return $this->output;
    }

    /**
     * @throws Exception
     */
    private function createPet(): Pet
    {
        return $this->petBuilder->build(
            species: $this->dataInput->species ?: $this->petCurrent->getSpeciesKey(),
            breedName: $this->dataInput->breedName ?: $this->petCurrent->getBreed()->getName()->getValue(),
            name: $this->dataInput->name ?: $this->petCurrent->getName()->getValue(),
            age: (int) $this->dataInput->age ?: $this->petCurrent->getAge()->getValue(),
            owner: $this->owner ?: $this->petCurrent->getOwner(),
            id: $this->dataInput->id
        );
    }

    /**
     * @throws Exception
     */
    private function update(Pet $pet): void
    {
        $this->petRepository->update($pet);
    }
}
