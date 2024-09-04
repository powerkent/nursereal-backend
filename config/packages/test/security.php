<?php

declare(strict_types=1);

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('security', [
        'password_hashers' => [
            PasswordAuthenticatedUserInterface::class => [
                'algorithm' => 'auto',
                'cost' => 4,
                'time_cost' => 3,
                'memory_cost' => 10,
            ],
        ],
    ]);
};
