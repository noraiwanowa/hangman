<?php

namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use Application\Service\GameManager;

/**
 * This is the factory class for GameManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class GameManagerFactory
{

    /**
     * This method creates the GAmeManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new GameManager($entityManager);
    }

}