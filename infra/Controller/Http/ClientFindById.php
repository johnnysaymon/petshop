<?php

declare(strict_types=1);

namespace App\Infra\Controller\Http;

use App\Domain\Entity\Client\ClientCollection;
use App\Domain\Repository\ClientRepository;
use App\Infra\Controller\ResourceNotFound;
use App\Infra\Presenter\ClientListing as ClientListingPresenter;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ClientFindById implements Controller
{
    private Request $request;

    public function __construct(
        private ClientRepository $clientRepository,
        private ClientListingPresenter $clientListingPresenter,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $this->request = $request;

        $id = $this->getId();

        $client = $this->clientRepository->findById($id);
        $collection = new ClientCollection();
        $collection->add($client);

        $this->clientListingPresenter->setClientCollection($collection);

        return $this->clientListingPresenter->make($response);
    }

    /**
     * @throws ResourceNotFound
     */
    private function getId(): string
    {
        $matches = [];
        preg_match('/\/([a-z\-0-9]+)\/$/', $this->request->getUri()->getPath(), $matches);

        if (! isset($matches[1])) {
            throw new ResourceNotFound('client.not-found');
        }

        return $matches[1];
    }
}
