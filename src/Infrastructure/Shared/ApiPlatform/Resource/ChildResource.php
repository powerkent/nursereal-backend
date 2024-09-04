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
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ChildInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ChildDeleteProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ChildPostProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ChildPutProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ChildCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ChildProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\CustomerView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\IRPView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructureView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\TreatmentView;
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
            provider: ChildCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['child:item', 'child:post:read']],
            denormalizationContext: ['groups' => ['child:item', 'child:post:write']],
            security: "is_granted('" . Roles::Manager->value . "')",
            input: ChildInput::class,
            processor: ChildPostProcessor::class,
        ),
        new Put(
            normalizationContext: ['groups' => ['child:item', 'child:put:read']],
            denormalizationContext: ['groups' => ['child:item', 'child:put:write']],
            security: "is_granted('" . Roles::Manager->value . "')",
            input: ChildInput::class,
            provider: ChildProvider::class,
            processor: ChildPutProcessor::class,
        ),
        new Delete(
            security: "is_granted('" . Roles::Manager->value . "')",
            provider: ChildProvider::class,
            processor: ChildDeleteProcessor::class,
        ),
    ]
)]
final class ChildResource
{
    /**
     * @param list<CustomerView>|null  $customers
     * @param list<TreatmentView>|null $treatments
     */
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $firstname,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $lastname,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $birthday,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public NurseryStructureView $nurseryStructure,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?DateTimeInterface $updatedAt = null,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?IRPView $irp = null,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        /** @var list<CustomerView>|null $customers */
        public ?array $customers = null,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        /** @var list<TreatmentView>|null $treatments */
        public ?array $treatments = null,
    ) {
    }
}
