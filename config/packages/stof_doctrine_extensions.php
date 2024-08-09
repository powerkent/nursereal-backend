<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('stof_doctrine_extensions', [
        'orm' => [
            'default' => [
                'timestampable' => true,
            ],
        ],
    ]);
};
