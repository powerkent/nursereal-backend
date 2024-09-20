<?php

declare(strict_types=1);

use Nursery\Infrastructure\Chat\Mercure\Provider\JwtProvider;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('mercure', [
        'enable_profiler' => '%kernel.debug%',
        'hubs' => [
            'default' => [
                'url' => '%env(MERCURE_URL)%',
                'jwt' => [
                    'secret' => '%env(MERCURE_JWT_SECRET)%',
                    'provider' => JwtProvider::class,
                    'publish' => '*',
                ],
            ],
        ],
    ]);
};
