<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->add('api_login_agent', '/api/login/agent')
        ->methods(['POST']);

    $routingConfigurator->import('.', 'api_platform')
        ->prefix('/api');
};
