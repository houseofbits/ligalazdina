<?php

namespace LigaLazdinaPortfolio\Helpers;

use DI\Container;
use DI\ContainerBuilder;

class Application
{
    private static ?Container $container = null;

    public static function getContainer(): Container
    {
        if (self::$container === null) {
            $builder = new ContainerBuilder();

            self::$container = $builder->build();
        }
        return self::$container;
    }

    public static function get(string $name)
    {
        return self::getContainer()->get($name);
    }
}