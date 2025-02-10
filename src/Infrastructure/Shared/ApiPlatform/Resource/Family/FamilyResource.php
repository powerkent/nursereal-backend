<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Family;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use DateTimeInterface;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\FamilyInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Family\FamilyDeleteProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Family\FamilyPostProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\Family\FamilyCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\Family\FamilyProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Child\ChildView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Customer\CustomerView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Family\TrustedPersonView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Family',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['family:item']],
            provider: FamilyProvider::class
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['family:list']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: FamilyCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['family:item', 'family:post:read']],
            denormalizationContext: ['groups' => ['family:item', 'family:post:write']],
            input: FamilyInput::class,
            provider: FamilyProvider::class,
            processor: FamilyPostProcessor::class,
        ),
        new Delete(
            security: "is_granted('".Roles::Manager->value."')",
            provider: FamilyProvider::class,
            processor: FamilyDeleteProcessor::class,
        ),
    ]
)]
class FamilyResource
{
    /**
     * @param array<int, ChildView>         $children
     * @param array<int, TrustedPersonView> $trustedPersons
     */
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['family:list', 'family:list'])]
        public UuidInterface $uuid,
        #[Groups(['family:list', 'family:list'])]
        public string $name,
        #[Groups(['family:list', 'family:list'])]
        public ?CustomerView $customerA,
        #[Groups(['family:list', 'family:list'])]
        public ?CustomerView $customerB,
        #[Groups(['family:list', 'family:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['family:list', 'family:list'])]
        public ?DateTimeInterface $updatedAt,
        #[Groups(['family:list', 'family:list'])]
        /** @var array<int, ChildView> */
        public array $children,
        #[Groups(['family:list', 'family:list'])]
        /** @var array<int, TrustedPersonView> */
        public array $trustedPersons,
    ) {
    }
}
