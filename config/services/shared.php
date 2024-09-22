<?php

declare(strict_types=1);

use Aws\S3\S3Client;
use Nursery\Infrastructure\Shared\ApiPlatform\OpenApi\ResourceMetadataFactory;
use Nursery\Infrastructure\Shared\Cloud\S3Uploader;
use Nursery\Infrastructure\Shared\Security\JWTCreatedListener;
use Nursery\Infrastructure\Shared\Symfony\Decoder\MultipartDecoder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('Nursery\\Domain\\Shared\\', __DIR__.'/../../src/Domain/Shared');
    $services->load('Nursery\\Application\\Shared\\', __DIR__.'/../../src/Application/Shared');
    $services->load('Nursery\\Infrastructure\\Shared\\', __DIR__.'/../../src/Infrastructure/Shared')
        ->exclude([__DIR__.'/../../src/Infrastructure/Shared/Symfony/Kernel.php']);

    $services->load('Nursery\\Infrastructure\\Shared\\ApiPlatform\\Action\\', __DIR__.'/../../src/Infrastructure/Shared/ApiPlatform/Action')
        ->tag('controller.service_arguments');

    $services->set(ResourceMetadataFactory::class)
        ->decorate('api_platform.openapi.factory')
        ->arg('$resources', tagged_iterator('shared.resource.open_api_context'))
        ->autoconfigure(false);

    $services->set(JWTCreatedListener::class)
        ->tag('kernel.event_listener', [
            'event' => 'lexik_jwt_authentication.on_jwt_created',
            'method' => 'onJWTCreated',
        ]);

    $services->set(MultipartDecoder::class)
        ->tag('serializer.encoder');

    $services->set(S3Client::class)
        ->factory([S3Client::class, 'factory'])
        ->args([
            [
                'version' => 'latest',
                'region' => env('AWS_DEFAULT_REGION'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]
        ]);

    $services->set(S3Uploader::class)
        ->args([
            service(S3Client::class),
            env('AWS_BUCKET_NAME'),
        ]);
};
