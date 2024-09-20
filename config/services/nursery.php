<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('Nursery\\Domain\\Nursery\\', __DIR__.'/../../src/Domain/Nursery');
    $services->load('Nursery\\Application\\Nursery\\', __DIR__.'/../../src/Application/Nursery');
    $services->load('Nursery\\Infrastructure\\Nursery\\', __DIR__.'/../../src/Infrastructure/Nursery');
};
