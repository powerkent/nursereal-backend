<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('doctrine', [
        'dbal' => [
            'connections' => [
                'default' => [
                    'dbname' => 'main_test%env(default::TEST_TOKEN)%',
                    'use_savepoints' => true,
                ],
            ],
        ],
    ]);
};
