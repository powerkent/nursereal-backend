<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('vich_uploader', [
        'db_driver' => 'orm',
        'storage' => 'flysystem',
        'mappings' => [
            'avatar' => [
                'uri_prefix' => '/avatar',
                'upload_destination' => 'avatar.storage',
            ],
        ],
    ]);
};
