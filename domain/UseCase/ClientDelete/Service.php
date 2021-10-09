<?php

declare(strict_types=1);

namespace App\Domain\UseCase\ClientDelete;

use App\Domain\Repository\ClientRepository;
use App\Domain\Repository\PetRepository;
use Exception;
use Throwable;

final class Service
{
    private Output $output;

    public function __construct(
        private ClientRepository $clientRepository,
        private PetRepository $petRepository,
    ){
        $this->output = new Output();
    }

    /**
     * @throws Exception
     */
    public function run(DataInput $dataInput): Output
    {
        $this->clientRepository->beginTransaction();
        $this->petRepository->beginTransaction();

        try {
            $this->clientRepository->delete($dataInput->id);
            $this->petRepository->deleteAllFromOwnerId($dataInput->id);
        } catch (Throwable $throwable) {
            $this->clientRepository->rollBackTransaction();
            $this->petRepository->rollBackTransaction();
            throw $throwable;
        }

        $this->clientRepository->commitTransaction();
        $this->petRepository->commitTransaction();

        return $this->output;
    }
}
