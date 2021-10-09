<?php

declare(strict_types=1);

namespace App\Infra\Container;

use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

final class Factory
{
    public static function create(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions( __DIR__ . '/../../container/main.php');
        return $containerBuilder->build();
    }
}
