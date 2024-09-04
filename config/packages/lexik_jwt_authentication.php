<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $container->extension('lexik_jwt_authentication', [
        'secret_key' => '%kernel.project_dir%/config/jwt/private.pem',  // Chemin vers la clé privée
        'public_key' => '%kernel.project_dir%/config/jwt/public.pem',   // Chemin vers la clé publique
        'pass_phrase' => '%env(JWT_PASSPHRASE)%',                       // Passphrase pour la clé privée
        'token_ttl' => 3600,                                            // Durée de vie du token en secondes
        'clock_skew' => 0,                                              // Pour ajuster une éventuelle dérive de l'horloge
    ]);
};