<?php

declare(strict_types=1);

namespace App\Infra\Controller\Http;

use App\Domain\Repository\PetRepository;
use App\Infra\Presenter\PetListingApi;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class PetListing implements Controller
{
    public function __construct(
        private PetRepository $petRepository,
        private PetListingApi $petListingApi,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $petCollection = $this->petRepository->findAll();

        $this->petListingApi->setPetCollection($petCollection);

        return $this->petListingApi->make($response);
    }
}
