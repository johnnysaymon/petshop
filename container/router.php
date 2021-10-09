<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;

return [
    App::class => function(ContainerInterface $container): App
    {
        AppFactory::setContainer($container);
        return AppFactory::create();
    }
];