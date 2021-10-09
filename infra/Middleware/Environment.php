<?php

declare(strict_types=1);

namespace App\Infra\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use function date_default_timezone_set;
use function setlocale;

final class Environment implements Middleware
{
    private function config(): self
    {
        ini_set('error_log', __DIR__ . '/../../storage/log/error.log');
        setlocale(LC_ALL, 'pt_BR.UTF-8');
        date_default_timezone_set('America/Fortaleza');

        return $this;
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        $this->config();
        $response = $handler->handle($request);
        $response = $response->withAddedHeader('SameSite', 'Strict');
        return $response;
    }
}
