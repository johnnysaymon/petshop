<?php

declare(strict_types=1);

use App\Infra\Container\Factory as ContainerFactory;
use App\Infra\Controller\Http\ClientCreate;
use App\Infra\Controller\Http\ClientFindById;
use App\Infra\Controller\Http\ClientListing;
use App\Infra\Controller\Http\PetCreate;
use App\Infra\Controller\Http\PetListing;
use App\Infra\Controller\Http\PetShow;
use App\Infra\Handler\Error;
use App\Infra\Middleware\Environment as EnvironmentMiddleware;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/** @var  ContainerInterface */
$container = ContainerFactory::create();

/** @var App */
$app = $container->get(App::class);

$app->addRoutingMiddleware();
$app->add(EnvironmentMiddleware::class);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler(Error::class);

$app->group('/client', function (RouteCollectorProxy $group)
{
    $group->get('/', ClientListing::class);

    $group->post('/', ClientCreate::class);

    $group->get('/{id}/', ClientFindById::class);
});

$app->group('/pet', function (RouteCollectorProxy $group)
{
    $group->get('/', PetListing::class);

    $group->post('/', PetCreate::class);

    $group->get('/{id}/', PetShow::class);
});


$app->run();
