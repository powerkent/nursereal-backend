<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Treatment;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use DateTimeInterface;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Shared\ApiPlatform\Payload\TreatmentPayload;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Treatment\TreatmentDeleteProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Treatment\TreatmentProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\Treatment\TreatmentCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\Treatment\TreatmentProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Child\ChildView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Dosage\DosageView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Treatment',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['treatment:item']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: TreatmentProvider::class,
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['treatment:list']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: TreatmentCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['treatment:item', 'treatment:post:read']],
            denormalizationContext: ['groups' => ['treatment:item', 'treatment:post:write']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            input: TreatmentPayload::class,
            processor: TreatmentProcessor::class,
        ),
        new Delete(
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: TreatmentProvider::class,
            processor: TreatmentDeleteProcessor::class,
        ),
    ]
)]
final class TreatmentResource
{
    /**
     * @param array<int, DosageView> $dosages
     */
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['treatment:item', 'treatment:list'])]
        public UuidInterface $uuid,
        #[Groups(['treatment:item', 'treatment:list'])]
        public ?ChildView $child,
        #[Groups(['treatment:item', 'treatment:list'])]
        public string $name,
        #[Groups(['treatment:item', 'treatment:list'])]
        public string $description,
        #[Groups(['treatment:item', 'treatment:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['treatment:item', 'treatment:list'])]
        public DateTimeInterface $startAt,
        #[Groups(['treatment:item', 'treatment:list'])]
        public ?DateTimeInterface $endAt = null,
        #[Groups(['treatment:item', 'treatment:list'])]
        /** @var array<int, DosageView> $dosages */
        public array $dosages = [],
    ) {
    }
}
