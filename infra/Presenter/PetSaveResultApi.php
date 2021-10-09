<?php

declare(strict_types=1);

namespace App\Infra\Presenter;

use App\Domain\UseCase\PetSave\Output;
use App\Domain\UseCase\PetSave\Service;
use Psr\Http\Message\ResponseInterface as Response;
use Exception;

use function json_encode;

abstract class PetSaveResultApi
{
    protected Output $output;

    abstract protected function generateResponseBodySuccess(): string;

    abstract protected function getCodeStatusSuccess(): int;

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
            throw new Exception('No output in pet save', 1);
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
        return $this->output->status() ? $this->getCodeStatusSuccess() : 422;
    }

    private function generateResponseBody(): string
    {
        return $this->output->status()
            ? $this->generateResponseBodySuccess()
            : $this->generateResponseBodyError();
    }

    private function generateResponseBodyError(): string
    {
        return json_encode([
            'status' => false,
            'field' => [
                'name' => $this->createFieldError($this->output->statusName(), $this->output->errorNameCode),
                'age' => $this->createFieldError($this->output->statusAge(), $this->output->errorAgeCode),
                'species' => $this->createFieldError($this->output->statusSpecies(), $this->output->errorSpeciesCode),
                'breedName' => $this->createFieldError($this->output->statusBreedName(), $this->output->errorBreedNameCode),
                'owner' => $this->createFieldError($this->output->statusOwner(), $this->output->errorOwnerCode),
            ]
        ]);
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
