<?php

declare(strict_types=1);

namespace App\Infra\Controller\Http;

use App\Domain\Repository\PetRepository;
use App\Infra\Controller\Http\Help\HelpExtractRequest;
use App\Infra\Controller\ResourceNotFound;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class PetDelete implements Controller
{
    use HelpExtractRequest;

    private Request $request;

    public function __construct(
        private PetRepository $petRepository
    ){}

    /**
     * @throws ResourceNotFound
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $this->request= $request;
        $id = $this->getId();

        $this->petRepository->delete($id);

        return $response
            ->withStatus(204)
            ->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
