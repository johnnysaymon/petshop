<?php

declare(strict_types=1);

namespace App\Infra\Controller\Http;

use App\Domain\UseCase\ClientUpdate\DataInput;
use App\Domain\UseCase\ClientUpdate\Service as ClientUpdateUseCase;
use App\Infra\Controller\ResourceNotFound;
use App\Infra\Presenter\ClientUpdateResultApi;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ClientUpdate implements Controller
{
    private Request $request;

    public function __construct(
        private ClientUpdateUseCase $clientUpdateUseCase,
        private ClientUpdateResultApi $clientUpdatePresenter,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $this->request = $request;

        $dataInput = $this->createDataInput();
        $output = $this->clientUpdateUseCase->run($dataInput);

        $this->clientUpdatePresenter->setOutput($output);
        return $this->clientUpdatePresenter->make($response);
    }

    private function createDataInput(): DataInput
    {
        $dataRequest = json_decode($this->request->getBody()->getContents(), true);
        $dataRequest['id'] = $this->getId();
        return DataInput::createFromArray($dataRequest);
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
