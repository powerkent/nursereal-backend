<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('api_platform', [
        'title' => 'Nursery',
        'version' => '%env(API_VERSION)%',
        'mapping' => [
            'paths' => [
                '%kernel.project_dir%/src/Infrastructure/Nursery/ApiPlatform/Resource',
                '%kernel.project_dir%/src/Infrastructure/Shared/ApiPlatform/Resource',
            ],
        ],
        'defaults' => [
            'normalization_context' => ['skip_null_values' => false],
        ],
        'patch_formats' => [
            'json' => ['application/merge-patch+json'],
        ],
        'swagger' => [
            'versions' => [3],
            'api_keys' => [
                'JWT' => [
                    'name' => 'Authorization',
                    'type' => 'header',
                ],
            ],
        ],
        'show_webby' => false,
    ]);
};
