<?php

declare(strict_types=1);

namespace App\Infra\Presenter;

use App\Domain\Entity\Pet\Pet;
use Psr\Http\Message\ResponseInterface as Response;

use function json_encode;

final class PetShowApi
{
    private Pet $pet;

    public function setPet(Pet $pet): self
    {
        $this->pet = $pet;
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
            'data' => $this->pet
        ]);
    }
}
