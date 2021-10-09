<?php

declare(strict_types=1);

namespace App\Infra\Controller\Http;

use App\Domain\UseCase\PetUpdate\DataInput;
use App\Domain\UseCase\PetUpdate\Service as PetUpdateUseCase;
use App\Infra\Controller\ResourceNotFound;
use App\Infra\Presenter\PetUpdateResultApi;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class PetUpdate implements Controller
{
    private Request $request;

    public function __construct(
        private PetUpdateUseCase   $petUpdateUseCase,
        private PetUpdateResultApi $petUpdatePresenter,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $this->request = $request;

        $dataInput = $this->createDataInput();
        $output = $this->petUpdateUseCase->run($dataInput);

        $this->petUpdatePresenter->setOutput($output);
        return $this->petUpdatePresenter->make($response);
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
            throw new ResourceNotFound('pet.not-found');
        }

        return $matches[1];
    }
}
