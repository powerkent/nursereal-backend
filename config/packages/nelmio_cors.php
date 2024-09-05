<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerBuilder $container) {
    $container->loadFromExtension('nelmio_cors', [
        'defaults' => [
            'allow_credentials' => true,
            'allow_origin' => ['http://localhost:3000'],  // Origine autorisée (ton frontend React)
            'allow_headers' => ['Content-Type', 'Authorization'],  // Headers autorisés
            'allow_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],  // Méthodes HTTP autorisées
            'expose_headers' => ['Authorization'],  // Exposer les headers d'autorisation
            'max_age' => 3600,  // Durée de mise en cache des réponses CORS
        ],
        'paths' => [
            '^/api/' => [
                'allow_origin' => ['http://localhost:3000'],  // Origine autorisée
                'allow_headers' => ['Content-Type', 'Authorization'],  // Headers autorisés
                'allow_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],  // Méthodes HTTP autorisées
                'max_age' => 3600,  // Durée de mise en cache des réponses CORS
            ],
        ],
    ]);
};
