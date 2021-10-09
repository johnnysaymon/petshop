<?php

declare(strict_types=1);

namespace App\Infra\Handler;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Factory\ResponseFactory;
use Throwable;

final class Error
{
    public function __invoke(
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): Response
    {
        error_log(
            sprintf(
                'Erro: %s; File: %s, Line: %d', 
                $exception->getMessage(), 
                $exception->getFile(), 
                $exception->getLine()
            )
        );

        $erroCode = $exception instanceof HttpNotFoundException ? 404 : 500;

        $response = (new ResponseFactory)->createResponse($erroCode);
        $response = $response->withHeader('Content-Type', 'application/json');
        
        $response->getBody()->write(
            json_encode([
                'error' => $exception->getMessage()
            ])
        );

        return $response;
    }
}