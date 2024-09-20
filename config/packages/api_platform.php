<?php

declare(strict_types=1);

use ApiPlatform\Exception\InvalidArgumentException;
use Nursery\Domain\Shared\Exception\ContractDateShouldHaveSameDayDateException;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Exception\MissingPropertyException;
use Nursery\Domain\Shared\Exception\OnlyOneChildPerContractCalendarException;
use Nursery\Domain\Shared\Exception\SeveralChildrenOnSameTreatmentException;
use Nursery\Domain\Shared\Exception\TreatmentNotCorrectForChildException;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('api_platform', [
        'title' => 'Nursery',
        'version' => '%env(API_VERSION)%',
        'mapping' => [
            'paths' => [
                '%kernel.project_dir%/src/Infrastructure/Nursery/ApiPlatform/Resource',
                '%kernel.project_dir%/src/Infrastructure/Chat/ApiPlatform/Resource',
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
            EntityNotFoundException::class => 400,
            InvalidArgumentException::class => 400,
            ExtraAttributesException::class => 400,
            MissingConstructorArgumentsException::class => 400,
            OnlyOneChildPerContractCalendarException::class => 400,
            SeveralChildrenOnSameTreatmentException::class => 400,
            TreatmentNotCorrectForChildException::class => 400,
            ContractDateShouldHaveSameDayDateException::class => 400,
            MissingPropertyException::class => 400,
        ],
        'show_webby' => false,
    ]);
};
