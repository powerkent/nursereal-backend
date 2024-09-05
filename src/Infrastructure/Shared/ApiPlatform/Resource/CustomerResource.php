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
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\CustomerInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\CustomerDeleteProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\CustomerProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\CustomerCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\CustomerProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Customer',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['customer:item']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: CustomerProvider::class
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['customer:list']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: CustomerCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['customer:item', 'customer:post:read']],
            denormalizationContext: ['groups' => ['customer:item', 'customer:post:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: CustomerInput::class,
            provider: CustomerProvider::class,
            processor: CustomerProcessor::class,
        ),
        new Put(
            normalizationContext: ['groups' => ['customer:item', 'customer:put:read']],
            denormalizationContext: ['groups' => ['customer:item', 'customer:put:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: CustomerInput::class,
            provider: CustomerProvider::class,
            processor: CustomerProcessor::class,
        ),
        new Delete(
            security: "is_granted('".Roles::Manager->value."')",
            provider: CustomerProvider::class,
            processor: CustomerDeleteProcessor::class,
        ),
    ]
)]
final class CustomerResource
{
    /**
     * @param array<int, ChildView>|null $children
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
        /** @var list<ChildView>|null $children */
        public ?array $children = null,
    ) {
    }
}
