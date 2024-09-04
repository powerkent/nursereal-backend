<?php

declare(strict_types=1);

use Nursery\Infrastructure\Shared\ApiPlatform\Action\AgentLoginAction;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import('.', 'api_platform')
        ->prefix('/api');

    $routingConfigurator->add('api_login', '/api/login')
        ->controller([AgentLoginAction::class, '__invoke'])
        ->methods(['POST']);

    $routingConfigurator->add('api_logout', '/api/logout')
        ->methods(['GET', 'POST']);
};
