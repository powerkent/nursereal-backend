<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ChildPostInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ChildPostProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ChildProvider;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Child',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['child:item']],
            provider: ChildProvider::class,
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['child:list']],
        ),
        new Post(
            normalizationContext: ['groups' => ['child:item', 'child:post:read']],
            denormalizationContext: ['groups' => ['child:item', 'child:post:write']],
            input: ChildPostInput::class,
            processor: ChildPostProcessor::class,
        ),
    ]
)]
final class ChildResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $firstname,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $lastname,
    ) {
    }
}
