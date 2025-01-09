<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ShiftTypeInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent\ShiftTypeDeleteProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent\ShiftTypePostProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent\ShiftTypePutProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\Agent\ShiftTypeCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\Agent\ShiftTypeProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructure\NurseryStructureView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'ShiftType',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['shiftType:item']],
            security: "is_granted('".Roles::Manager->value."')",
            provider: ShiftTypeProvider::class
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['shiftType:list']],
            security: "is_granted('".Roles::Manager->value."')",
            provider: ShiftTypeCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['shiftType:item', 'shiftType:post:read']],
            denormalizationContext: ['groups' => ['shiftType:item', 'shiftType:post:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: ShiftTypeInput::class,
            processor: ShiftTypePostProcessor::class,
        ),
        new Put(
            normalizationContext: ['groups' => ['shiftType:item', 'shiftType:put:read']],
            denormalizationContext: ['groups' => ['shiftType:item', 'shiftType:put:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: ShiftTypeInput::class,
            provider: ShiftTypeProvider::class,
            processor: ShiftTypePutProcessor::class,
        ),
        new Delete(
            security: "is_granted('".Roles::Manager->value."')",
            provider: ShiftTypeProvider::class,
            processor: ShiftTypeDeleteProcessor::class,
        ),
    ],
)]
final class ShiftTypeResource
{
    /**
     * @param array<int, NurseryStructureView> $nurseryStructures
     */
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['shiftType:item', 'shiftType:list'])]
        public UuidInterface $uuid,
        #[ApiProperty(identifier: false)]
        #[Groups(['shiftType:item', 'shiftType:list'])]
        public ?int $id,
        #[Groups(['shiftType:item', 'shiftType:list'])]
        public string $name,
        #[Groups(['shiftType:item', 'shiftType:list'])]
        public string $arrivalTime,
        #[Groups(['shiftType:item', 'shiftType:list'])]
        public string $endOfWorkTime,
        #[Groups(['shiftType:item', 'shiftType:list'])]
        public string $breakTime,
        #[Groups(['shiftType:item', 'shiftType:list'])]
        public string $endOfBreakTime,
        #[Groups(['shiftType:item', 'shiftType:list'])]
        /** @var list<NurseryStructureView> $nurseryStructures */
        public array $nurseryStructures,
    ) {
    }
}
