<?php

namespace LigaLazdinaPortfolio\Services;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMSetup;

class EntityManagerInstance extends EntityManager
{
    /**
     * @throws ORMException
     */
    public function __construct()
    {
        $config = new Configuration();
        $driverImpl = ORMSetup::createDefaultAnnotationDriver(['src/Entities']);
        $config->setMetadataDriverImpl($driverImpl);
        $config->setProxyDir('src/Proxies');
        $config->setProxyNamespace('LigaLazdinaPortfolio\Proxies');
        $config->setAutoGenerateProxyClasses(false);

        $dbParams = array(
            'driver' => 'mysqli',
            'user' => $_ENV['MYSQL_USER'],
            'password' => $_ENV['MYSQL_PASSWORD'],
            'dbname' => $_ENV['MYSQL_DATABASE'],
            'host' => $_ENV['MYSQL_HOST'],
        );

        $connection = static::createConnection($dbParams, $config, null);

        parent::__construct($connection, $config, $connection->getEventManager());
    }
}