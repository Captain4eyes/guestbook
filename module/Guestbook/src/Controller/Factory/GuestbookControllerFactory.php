<?php
/**
 * Created by PhpStorm.
 * User: Ming
 * Date: 04.06.2019
 * Time: 16:19
 */

namespace Guestbook\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Guestbook\Controller\GuestbookController;
use Guestbook\Service\GuestbookManager;


/**
 * Class GuestbookControllerFactory
 * @package Guestbook\Controller\Factory
 */
class GuestbookControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $guestbookManager = $container->get(GuestbookManager::class);

        return new GuestbookController($entityManager, $guestbookManager);
    }
}