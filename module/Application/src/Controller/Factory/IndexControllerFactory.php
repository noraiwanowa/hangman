<?php
namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;
use Application\Controller\IndexController;
use Application\Service\GameManager;

/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $sessionContainer = $container->get('ContainerNamespace');

        $gameManager = $container->get(GameManager::class);
        
        // Instantiate the controller and inject dependencies
        return new IndexController($entityManager,$sessionContainer,$gameManager);
    }
}