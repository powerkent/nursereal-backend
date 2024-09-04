<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $container->extension('lexik_jwt_authentication', [
        'secret_key' => '%kernel.project_dir%/config/jwt/private.pem',
        'public_key' => '%kernel.project_dir%/config/jwt/public.pem',
        'pass_phrase' => '%env(JWT_PASSPHRASE)%',
        'token_ttl' => 3600*24,
        'encoder' => [
            'signature_algorithm' => 'RS256'
        ],
    ]);
};
