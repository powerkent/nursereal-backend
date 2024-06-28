<?php

declare(strict_types=1);

use Ramsey\Uuid\Doctrine\UuidType;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('doctrine', [
        'dbal' => [
            'default_connection' => 'default',
            'types' => [
                UuidType::NAME => UuidType::class,
            ],
            'connections' => [
                'default' => ['url' => '%env(resolve:DATABASE_URL)%'],
            ],
        ],
        'orm' => [
            'default_entity_manager' => 'default',
            'auto_generate_proxy_classes' => true,
            'entity_managers' => [
                'default' => [
                    'connection' => 'default',
                    'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
                    'auto_mapping' => true,
                    'mappings' => [
                        'Nursery' => [
                            'is_bundle' => false,
                            'type' => 'xml',
                            'dir' => '%kernel.project_dir%/src/Infrastructure/Nursery/Doctrine/Mapping',
                            'prefix' => 'Nursery\Domain\Nursery\Model',
                        ],
                        'Shared' => [
                            'is_bundle' => false,
                            'type' => 'xml',
                            'dir' => '%kernel.project_dir%/src/Infrastructure/Shared/Doctrine/Mapping',
                            'prefix' => 'Nursery\Domain\Shared\Model',
                        ],
                    ],
                    'metadata_cache_driver' => [
                        'type' => 'pool',
                        'pool' => 'doctrine.system_cache_pool',
                    ],
                    'query_cache_driver' => [
                        'type' => 'pool',
                        'pool' => 'doctrine.system_cache_pool',
                    ],
                    'result_cache_driver' => [
                        'type' => 'pool',
                        'pool' => 'doctrine.result_cache_pool',
                    ],
                ],
            ],
        ],
    ]);
    $containerConfigurator->extension('framework', [
        'cache' => [
            'pools' => [
                'doctrine.result_cache_pool' => [
                    'adapter' => 'cache.app',
                ],
                'doctrine.system_cache_pool' => [
                    'adapter' => 'cache.system',
                ],
            ],
        ],
    ]);
};
