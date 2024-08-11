<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use DateTimeInterface;
use Nursery\Domain\Shared\Enum\ActionType;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ActionInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ActionPostProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ActionPutProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ActionCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ActionProvider;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Action',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['action:list']],
            provider: ActionProvider::class,
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['action:list']],
            provider: ActionCollectionProvider::class,
        ),
        new Post(
            normalizationContext: ['groups' => ['child:item', 'child:post:read']],
            denormalizationContext: ['groups' => ['child:item', 'child:post:write']],
            input: ActionInput::class,
            processor: ActionPostProcessor::class,
        ),
        new Put(
            normalizationContext: ['groups' => ['child:item', 'child:put:read']],
            denormalizationContext: ['groups' => ['child:item', 'child:put:write']],
            input: ActionInput::class,
            provider: ActionProvider::class,
            processor: ActionPutProcessor::class,
        ),
    ]
)]
final class ActionResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['action:item', 'action:list'])]
        public UuidInterface $uuid,
        #[Groups(['action:item', 'action:list'])]
        protected ActionType $type,
        #[Groups(['action:item', 'action:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['action:item', 'action:list'])]
        public array $children,
        #[Groups(['action:item', 'action:list'])]
        protected ?string $comment = null,
    ) {
    }
}
