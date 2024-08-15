<?php

declare(strict_types=1);

use ApiPlatform\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
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
            'normalization_context' => ['skip_null_values' => true],
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
        'exception_to_status' => [
            InvalidArgumentException::class => 400,
            ExtraAttributesException::class => 400,
            MissingConstructorArgumentsException::class => 400,
        ],
        'show_webby' => false,
    ]);
};
