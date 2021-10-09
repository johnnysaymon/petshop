<?php

declare(strict_types=1);

namespace App\Infra\Controller\Http;

use App\Domain\Repository\ClientRepository;
use App\Infra\Presenter\ClientListing as ClientListingPresenter;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ClientListing implements Controller
{
    public function __construct(
        private ClientRepository $clientRepository,
        private ClientListingPresenter $clientListingPresenter,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $clientCollection = $this->clientRepository->findAll();

        $this->clientListingPresenter->setClientCollection($clientCollection);

        return $this->clientListingPresenter->make($response);
    }
}
