<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerBuilder $container) {
    $container->loadFromExtension('nelmio_cors', [
        'defaults' => [
            'allow_credentials' => true,
            'allow_origin' => ['http://localhost:3000', 'http://localhost:3001'],
            'allow_headers' => ['Content-Type', 'Authorization'],
            'allow_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
            'expose_headers' => ['Authorization'],
            'max_age' => 3600,
        ],
        'paths' => [
            '^/api/' => [
                'allow_origin' => ['http://localhost:3000', 'http://localhost:3001'],
                'allow_headers' => ['Content-Type', 'Authorization'],
                'allow_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                'max_age' => 3600,
            ],
        ],
    ]);
};
