<?php

declare(strict_types=1);

use Nursery\Infrastructure\Shared\ApiPlatform\OpenApi\ActionResourceOpenApiContext;
use Nursery\Infrastructure\Shared\ApiPlatform\OpenApi\ResourceMetadataFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ActionResource;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('Nursery\\Domain\\Shared\\', __DIR__.'/../../src/Domain/Shared');

    $services->load('Nursery\\Application\\Shared\\', __DIR__.'/../../src/Application/Shared');

    $services->load('Nursery\\Infrastructure\\Shared\\', __DIR__.'/../../src/Infrastructure/Shared')
        ->exclude([__DIR__.'/../../src/Infrastructure/Shared/Symfony/Kernel.php']);

    $services->set(ActionResourceOpenApiContext::class)
        ->tag('open_api_context', ['resource' => ActionResource::class]);

    $services->set(ResourceMetadataFactory::class)
        ->decorate('api_platform.openapi.factory')
        ->arg('$resources', tagged_iterator('shared.resource.open_api_context'))
        ->autoconfigure(false);
};
