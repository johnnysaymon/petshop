<?php

declare(strict_types=1);

namespace App\Infra\Presenter;

use App\Domain\UseCase\ClientUpdate\Output;
use App\Domain\UseCase\ClientUpdate\Service;
use Psr\Http\Message\ResponseInterface as Response;
use Exception;

use function json_encode;

final class ClientUpdateResultApi
{
    private Output $output;

    public function setOutput(Output $output): self
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function make(Response $response): Response
    {
        if (empty($this->output)) {
            throw new Exception('No output in client update', 1);
        }

        $response = $response
            ->withStatus($this->getStatus())
            ->withHeader('Content-Type', 'application/json; charset=utf-8');

        $response->getBody()->write(
            $this->generateResponseBody()
        );

        return $response;
    }

    private function getStatus(): int
    {
        return $this->output->status() ? 204 : 422;
    }

    private function generateResponseBody(): string
    {
        $body = $this->output->status()
            ? ''
            : $this->generateResponseBodyError();

        return json_encode($body);
    }

    private function generateResponseBodyError(): array
    {
        return [
            'status' => false,
            'field' => [
                'name' => $this->createFieldError($this->output->statusName(), $this->output->errorNameCode),
                'phone' => $this->createFieldError($this->output->statusPhone(), $this->output->errorPhoneCode),
            ]
        ];
    }

    private function createFieldError(bool $status, string $errorCode): array
    {
        return [
            'status' => $status,
            'message' => $status ? '' : $this->generateMessageError($errorCode)
        ];
    }

    private function generateMessageError(string $errorCode): string
    {
        return match ($errorCode) {
            Service::ERROR_EMPTY => 'Valor não informado',
            Service::ERROR_INVALID => 'Valor inválido',
            default => 'Erro desconhecido'
        };
    }
}
