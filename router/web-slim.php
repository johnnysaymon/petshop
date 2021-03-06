<?php

declare(strict_types=1);

use App\Infra\Container\Factory as ContainerFactory;
use App\Infra\Controller\Http\ClientCreate;
use App\Infra\Controller\Http\ClientDelete;
use App\Infra\Controller\Http\ClientFindById;
use App\Infra\Controller\Http\ClientListing;
use App\Infra\Controller\Http\ClientUpdate;
use App\Infra\Controller\Http\PetCreate;
use App\Infra\Controller\Http\PetDelete;
use App\Infra\Controller\Http\PetListing;
use App\Infra\Controller\Http\PetShow;
use App\Infra\Controller\Http\PetUpdate;
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

    $group->patch('/{id}/', ClientUpdate::class);

    $group->delete('/{id}/', ClientDelete::class);
});

$app->group('/pet', function (RouteCollectorProxy $group)
{
    $group->get('/', PetListing::class);

    $group->post('/', PetCreate::class);

    $group->get('/{id}/', PetShow::class);

    $group->patch('/{id}/', PetUpdate::class);

    $group->delete('/{id}/', PetDelete::class);
});


$app->run();
