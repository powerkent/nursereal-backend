<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Avatar;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use ArrayObject;
use Nursery\Domain\Shared\Enum\AvatarType;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AvatarInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\AvatarProcessor;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ApiResource(
    shortName: 'Avatar',
    operations: [
        new Post(
            inputFormats: ['multipart' => ['multipart/form-data']],
            openapi: new Model\Operation(
                requestBody: new Model\RequestBody(
                    description: 'Upload an avatar',
                    content: new ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'objectUuid' => [
                                        'type' => 'string',
                                        'format' => 'uuid',
                                        'example' => '123e4567-e89b-12d3-a456-426614174000',
                                    ],
                                    'type' => [
                                        'type' => 'string',
                                        'enum' => [AvatarType::Agent->value, AvatarType::Customer->value, AvatarType::Child->value],
                                        'example' => AvatarType::Agent->value,
                                    ],
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                ],
                                'required' => ['objectUuid', 'type', 'file'],
                            ],
                        ],
                    ]),
                    required: true,
                )
            ),
            normalizationContext: ['groups' => ['avatar:item', 'avatar:post:read']],
            denormalizationContext: ['groups' => ['avatar:item', 'avatar:post:write']],
            input: AvatarInput::class,
            processor: AvatarProcessor::class,
        ),
    ],
)]
final class AvatarResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['avatar:item'])]
        public ?int $id,
        #[Groups(['avatar:item'])]
        public AvatarType $type,
        #[Groups(['avatar:item'])]
        public string $contentUrl,
    ) {
    }
}
