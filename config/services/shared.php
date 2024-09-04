<?php

declare(strict_types=1);

use Nursery\Domain\Shared\Listener\GuardInterface;
use Nursery\Infrastructure\Nursery\Symfony\Security\AgentAuthenticator;
use Nursery\Infrastructure\Shared\ApiPlatform\OpenApi\ResourceMetadataFactory;
use Nusery\Infrastructure\Shared\Listener\PreventChildrenOnPostCalendarGuard;
use Nusery\Infrastructure\Shared\Listener\PreventContractDateOnlyOneDayGuard;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('Nursery\\Domain\\Shared\\', __DIR__.'/../../src/Domain/Shared');

    $services->load('Nursery\\Application\\Shared\\', __DIR__.'/../../src/Application/Shared');

    $services->load('Nursery\\Infrastructure\\Shared\\', __DIR__.'/../../src/Infrastructure/Shared')
        ->exclude([__DIR__.'/../../src/Infrastructure/Shared/Symfony/Kernel.php']);

    $services->load('Nursery\\Infrastructure\\Shared\\ApiPlatform\\Action\\', __DIR__.'/../../src/Infrastructure/Shared/ApiPlatform/Action')
        ->tag('controller.service_arguments');

    $services->set(AgentAuthenticator::class)
        ->args([
            '$jwtEncoder' => service('lexik_jwt_authentication.jwt_manager'),
        ])
        ->tag('security.authenticator');;

    $services->set(ResourceMetadataFactory::class)
        ->decorate('api_platform.openapi.factory')
        ->arg('$resources', tagged_iterator('shared.resource.open_api_context'))
        ->autoconfigure(false);

    $services->set(GuardInterface::class, PreventChildrenOnPostCalendarGuard::class)
        ->set(GuardInterface::class, PreventContractDateOnlyOneDayGuard::class)
        ->tag('kernel.event_listener', [
            'event' => 'kernel.request',
            'method' => 'onKernelRequest',
        ]);
};
