<?php

declare(strict_types=1);

namespace App\Infra\Controller\Http;

use App\Domain\UseCase\CreatePet\DataInput;
use App\Domain\UseCase\CreatePet\Service as CreatePetUseCase;
use App\Infra\Presenter\PetCreateResultApi;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class PetCreate implements Controller
{
    private Request $request;

    public function __construct(
        private CreatePetUseCase      $createPetUseCase,
        private PetCreateResultApi $petCreateResultPresenter,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $this->request = $request;

        $dataInput = $this->createDataInput();
        $output = $this->createPetUseCase->run($dataInput);

        $this->petCreateResultPresenter->setOutput($output);
        return $this->petCreateResultPresenter->make($response);
    }

    private function createDataInput(): DataInput
    {
        $dataRequest = json_decode($this->request->getBody()->getContents(), true);
        unset($dataRequest['id']);
        return DataInput::createFromArray($dataRequest);
    }
}
