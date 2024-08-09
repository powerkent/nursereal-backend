<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use DateTimeInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ActivityInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ActivityDeleteProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ActivityProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ActivityProvider;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Activity',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['activity:item']],
            provider: ActivityProvider::class,
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['activity:list']],
        ),
        new Post(
            normalizationContext: ['groups' => ['activity:item', 'activity:post:read']],
            denormalizationContext: ['groups' => ['activity:item', 'activity:post:write']],
            input: ActivityInput::class,
            processor: ActivityProcessor::class,
        ),
        new Put(
            normalizationContext: ['groups' => ['activity:item', 'activity:put:read']],
            denormalizationContext: ['groups' => ['activity:item', 'activity:put:write']],
            input: ActivityInput::class,
            provider: ActivityProvider::class,
            processor: ActivityProcessor::class,
        ),
        new Delete(
            provider: ActivityProvider::class,
            processor: ActivityDeleteProcessor::class,
        ),
    ]
)]
final class ActivityResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['activity:item', 'activity:list'])]
        public UuidInterface $uuid,
        #[Groups(['activity:item', 'activity:list'])]
        public string $name,
        #[Groups(['activity:item', 'activity:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['activity:item', 'activity:list'])]
        public ?string $description = null,
    ) {
    }
}
