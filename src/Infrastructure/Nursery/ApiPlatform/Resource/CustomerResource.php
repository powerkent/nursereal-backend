<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\CustomerPostInput;
use Nursery\Infrastructure\Nursery\ApiPlatform\Processor\CustomerPostProcessor;
use Nursery\Infrastructure\Nursery\ApiPlatform\Provider\CustomerCollectionProvider;
use Nursery\Infrastructure\Nursery\ApiPlatform\Provider\CustomerProvider;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Customer',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['customer:item']],
            provider: CustomerProvider::class
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['customer:list']],
            provider: CustomerCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['customer:item', 'customer:post:read']],
            denormalizationContext: ['groups' => ['customer:item', 'customer:post:write']],
            input: CustomerPostInput::class,
            processor: CustomerPostProcessor::class,
        ),
    ]
)]
final class CustomerResource
{
    /**
     * @param array<int, ChildResource>|null $children
     */
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['customer:item', 'customer:list'])]
        public UuidInterface $uuid,
        #[Groups(['customer:item', 'customer:list'])]
        public string $firstname,
        #[Groups(['customer:item', 'customer:list'])]
        public string $lastname,
        #[Groups(['customer:item', 'customer:list'])]
        public ?string $email,
        #[Groups(['customer:item', 'customer:list'])]
        public int $phoneNumber,
        #[Groups(['customer:item', 'customer:list'])]
        public ?array $children = null,
    ) {
    }
}
