<?php

declare(strict_types=1);

use App\Infra\Container\Factory as ContainerFactory;
use App\Infra\Controller\Http\ClientCreate;
use App\Infra\Controller\Http\ClientFindById;
use App\Infra\Controller\Http\ClientListing;
use App\Infra\Controller\Http\PetCreate;
use App\Infra\Controller\Http\PetListing;
use App\Infra\Handler\Error;
use App\Infra\Middleware\Environment as EnvironmentMiddleware;
use Psr\Container\ContainerInterface;
use Slim\App;

/** @var  ContainerInterface */
$container = ContainerFactory::create();

/** @var App */
$app = $container->get(App::class);

$app->addRoutingMiddleware();
$app->add(EnvironmentMiddleware::class);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler(Error::class);

$app->get('/client/', ClientListing::class);

$app->post('/client/', ClientCreate::class);

$app->get('/client/{id}/', ClientFindById::class);

$app->get('/pet/', PetListing::class);

$app->post('/pet/', PetCreate::class);

$app->run();
