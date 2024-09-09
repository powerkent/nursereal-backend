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
use Nursery\Infrastructure\Shared\ApiPlatform\Input\NurseryStructureInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\NurseryStructureDeleteProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\NurseryStructureProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\NurseryStructureCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\NurseryStructureProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\AgentView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'NurseryStructure',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['nurseryStructure:item']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: NurseryStructureProvider::class
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['nurseryStructure:list']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: NurseryStructureCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['nurseryStructure:item', 'nurseryStructure:post:read']],
            denormalizationContext: ['groups' => ['nurseryStructure:item', 'nurseryStructure:post:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: NurseryStructureInput::class,
            processor: NurseryStructureProcessor::class,
        ),
        new Put(
            normalizationContext: ['groups' => ['nurseryStructure:item', 'nurseryStructure:put:read']],
            denormalizationContext: ['groups' => ['nurseryStructure:item', 'nurseryStructure:put:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: NurseryStructureInput::class,
            provider: NurseryStructureProvider::class,
            processor: NurseryStructureProcessor::class,
        ),
        new Delete(
            security: "is_granted('".Roles::Manager->value."')",
            provider: NurseryStructureProvider::class,
            processor: NurseryStructureDeleteProcessor::class,
        ),
    ]
)]
final class NurseryStructureResource
{
    /**
     * @param list<ChildView>|null $children
     * @param list<AgentView>|null $agents
     */
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public UuidInterface $uuid,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public string $name,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public string $address,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public ?DateTimeInterface $updatedAt,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public ?DateTimeInterface $startAt,
        #[Groups(['nurseryStructure:item'])]
        /** @var list<AgentView>|null $agents */
        public ?array $agents = null,
        #[Groups(['nurseryStructure:item'])]
        /** @var list<ChildView>|null */
        public ?array $children = null,
    ) {
    }
}
