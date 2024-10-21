<?php

declare(strict_types=1);

use Aws\S3\S3Client;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('flysystem', [
        'storages' => [
            'avatar.storage' => [
                'adapter' => 'aws',
                'options' => [
                    'client' => S3Client::class,
                    'bucket' => env('AWS_BUCKET_NAME'),
                    'prefix' => 'avatar',
                ],
            ],
        ],
    ]);
};
