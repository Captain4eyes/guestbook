<?php
/**
 * Created by PhpStorm.
 * User: Ming
 * Date: 03.06.2019
 * Time: 13:07
 */

namespace Guestbook;

use Zend\Router\Http\Segment;
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'controllers' => [
        'factories' => [
            Controller\GuestbookController::class => Controller\Factory\GuestbookControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            Service\GuestbookManager::class => Service\Factory\GuestbookManagerFactory::class,
        ],
    ],

    'router' => [
        'routes' => [
            'guestbook' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/[:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\GuestbookController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/guestbook/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/guestbook/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/guestbook/error/index.phtml',
        ],
        'template_path_stack' => [
            'Guestbook' => __DIR__ . '/../view',
        ],
    ],

    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => PDOMySqlDriver::class,
                'params' => [
                    'host'     => '127.0.0.1',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => '',
                    'dbname'   => 'guestbook',
                ]
            ],
        ],
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'data/Migrations',
                'name'      => 'Doctrine Database Migrations',
                'namespace' => 'Migrations',
                'table'     => 'migrations',
            ],
        ],
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ],
    ],
];