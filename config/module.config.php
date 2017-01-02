<?php
namespace Slug;

use Boxspaced\EntityManager\Entity\AbstractEntity;
use Core\Model\RepositoryFactory;
use Core\Model\Module as AppModule;

return [
    'router' => [
        'routes' => [
            // LIFO
            'content' => [
                'type' => Router\SlugRoute::class,
                'options' => [
                    'defaults' => [
                        'slug' => 'home',
                    ],
                ],
            ],
            // LIFO
        ],
        'plugin_manager' => [
            'factories' => [
                Router\SlugRoute::class => Router\SlugRouteFactory::class,
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Model\RouteRepository::class => RepositoryFactory::class,
        ]
    ],
    'entity_manager' => [
        'types' => [
            Model\Route::class => [
                'mapper' => [
                    'params' => [
                        'table' => 'route',
                        'columns' => [
                            'module' => 'module_id',
                        ],
                    ],
                ],
                'entity' => [
                    'fields' => [
                        'id' => [
                            'type' => AbstractEntity::TYPE_INT,
                        ],
                        'slug' => [
                            'type' => AbstractEntity::TYPE_STRING,
                        ],
                        'identifier' => [
                            'type' => AbstractEntity::TYPE_STRING,
                        ],
                        'module' => [
                            'type' => AppModule::class,
                        ],
                    ],
                ],
            ],
        ],
    ],
];
