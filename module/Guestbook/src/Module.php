<?php
/**
 * Created by PhpStorm.
 * User: Ming
 * Date: 03.06.2019
 * Time: 13:03
 */

namespace Guestbook;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class Module
 * @package Guestbook
 */
class Module implements ConfigProviderInterface
{
    const VERSION = '0.1-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}