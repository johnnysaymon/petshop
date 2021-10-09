<?php

declare(strict_types=1);

namespace App\Infra\Controller\Http;

use App\Domain\Repository\PetRepository;
use App\Infra\Controller\ResourceNotFound;
use App\Infra\Presenter\PetShowApi;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class PetShow implements Controller
{
    private Request $request;

    public function __construct(
        private PetRepository $petRepository,
        private PetShowApi $petPresenter,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $this->request = $request;

        $id = $this->getId();
        $pet = $this->petRepository->findById($id);

        $this->petPresenter->setPet($pet);
        return $this->petPresenter->make($response);
    }

    /**
     * @throws ResourceNotFound
     */
    private function getId(): string
    {
        $matches = [];
        preg_match('/\/([a-z\-0-9]+)\/$/', $this->request->getUri()->getPath(), $matches);

        if (! isset($matches[1])) {
            throw new ResourceNotFound('pet.not-found');
        }

        return $matches[1];
    }
}
