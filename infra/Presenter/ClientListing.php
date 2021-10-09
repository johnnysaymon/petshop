<?php

declare(strict_types=1);

namespace App\Infra\Presenter;

use App\Domain\Entity\Client\ClientCollection;
use Psr\Http\Message\ResponseInterface as Response;

use function json_encode;

final class ClientListing
{
    private ClientCollection $clientCollection;

    public function setClientCollection(ClientCollection $clientCollection): self
    {
        $this->clientCollection = $clientCollection;
        return $this;
    }

    public function make(Response $response): Response
    {
        $response = $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json; charset=utf-8');

        $response->getBody()->write(
            $this->generateResponseBody()
        );

        return $response;
    }

    private function generateResponseBody(): string
    {
        return json_encode([
            'status' => true,
            'data' => $this->clientCollection
        ]);
    }
}
