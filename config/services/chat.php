<?php

declare(strict_types=1);

use Nursery\Infrastructure\Chat\Mercure\Provider\JwtProvider;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('Nursery\\Domain\\Chat\\', __DIR__.'/../../src/Domain/Chat');
    $services->load('Nursery\\Application\\Chat\\', __DIR__.'/../../src/Application/Chat');
    $services->load('Nursery\\Infrastructure\\Chat\\', __DIR__.'/../../src/Infrastructure/Chat');

    $services->set(JwtProvider::class)
        ->arg('$key', env('MERCURE_JWT_SECRET'));
};
