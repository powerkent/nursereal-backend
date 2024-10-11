<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('monolog', [
        'handlers' => [
            'main' => [
                'type' => 'fingers_crossed',
                'action_level' => 'error',
                'handler' => 'nested',
                'excluded_http_codes' => [
                    404,
                    405,
                ],
                'buffer_size' => 50,
            ],
            'nested' => [
                'type' => 'stream',
                'path' => 'php://stderr',
                'level' => 'debug',
                'formatter' => 'monolog.formatter.json',
            ],
            'console' => [
                'type' => 'console',
                'process_psr_3_messages' => false,
                'channels' => [
                    '!event',
                    '!doctrine',
                ],
            ],
            'deprecation' => [
                'type' => 'stream',
                'channels' => [
                    'deprecation',
                ],
                'path' => 'php://stderr',
                'formatter' => 'monolog.formatter.json',
            ],
        ],
    ]);
};
