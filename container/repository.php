<?php

use App\Domain\Repository\ClientRepository;
use App\Domain\Repository\PetRepository;
use App\Infra\Repository\ClientPdo;
use App\Infra\Repository\PetPdo;
use Psr\Container\ContainerInterface as Container;

return [
    ClientRepository::class => function(Container $container): ClientRepository
    {
        return $container->get(ClientPdo::class);
    },

    PetRepository::class => function(Container $container): PetRepository
    {
        return $container->get(PetPdo::class);
    },
];
