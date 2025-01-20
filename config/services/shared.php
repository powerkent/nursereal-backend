<?php

declare(strict_types=1);

use Aws\S3\S3Client;
use League\Flysystem\FilesystemOperator;
use Nursery\Infrastructure\Shared\ApiPlatform\OpenApi\ResourceMetadataFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent\AgentPatchProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Serializer\DeserializeListener;
use Nursery\Infrastructure\Shared\ApiPlatform\Serializer\MultipartDenormalizer;
use Nursery\Infrastructure\Shared\Security\JWTCreatedListener;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
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

    $services->set(S3Client::class)
        ->args([[
            'credentials' => [
                'key'    => '%env(AWS_ACCESS_KEY_ID)%',
                'secret' => '%env(AWS_SECRET_ACCESS_KEY)%',
            ],
            'region'  => '%env(AWS_REGION)%',
            'version' => 'latest',
            'endpoint' => '%env(default::AWS_ENDPOINT)%',
            'use_path_style_endpoint' => true,
        ]]);

    $services->set(MultipartDenormalizer::class)
        ->arg('$requestStack', new Reference('request_stack'))
        ->tag('serializer.denormalizer');

    $services->alias(FilesystemOperator::class.' $avatarStorage', 'avatar.storage');

    $services->set(DeserializeListener::class)
        ->tag('kernel.event_listener', ['event' => 'kernel.request', 'method' => 'onKernelRequest', 'priority' => 2])
        ->decorate('api_platform.listener.request.deserialize')
        ->autoconfigure(false);

    $services->set(AgentPatchProcessor::class)
        ->arg('$avatarUploadDir', __DIR__.'/../../volume/tmp');
};
