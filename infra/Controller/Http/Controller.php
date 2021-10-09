<?php

declare(strict_types=1);

namespace App\Infra\Controller\Http;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface Controller
{
    public function __invoke(Request $request, Response $response): Response;
}