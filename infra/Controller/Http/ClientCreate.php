<?php

declare(strict_types=1);

namespace App\Infra\Controller\Http;

use App\Domain\UseCase\ClientCreate\DataInput;
use App\Domain\UseCase\ClientCreate\Service as CreateClientUseCase;
use App\Infra\Presenter\ClientCreateResultApi;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ClientCreate implements Controller
{
    private Request $request;

    public function __construct(
        private CreateClientUseCase $createClientUseCase,
        private ClientCreateResultApi $clientCreateResultPresenter,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $this->request = $request;

        $dataInput = $this->createDataInput();
        $output = $this->createClientUseCase->run($dataInput);

        $this->clientCreateResultPresenter->setOutput($output);
        return $this->clientCreateResultPresenter->make($response);
    }

    private function createDataInput(): DataInput
    {
        $dataRequest = json_decode($this->request->getBody()->getContents(), true);
        unset($dataRequest['id']);
        return DataInput::createFromArray($dataRequest);
    }
}
