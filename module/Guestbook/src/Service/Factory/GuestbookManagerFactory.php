<?php
/**
 * Created by PhpStorm.
 * User: Ming
 * Date: 04.06.2019
 * Time: 23:32
 */

namespace Guestbook\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Guestbook\Service\GuestbookManager;


/**
 * Class GuestbookManagerFactory
 * @package Guestbook\Service\Factory
 */
class GuestbookManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new GuestbookManager($entityManager);
    }
}