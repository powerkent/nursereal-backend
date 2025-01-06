<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructure;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class NurseryStructureView
{
    /**
     * @param array<int, NurseryStructureOpeningView> $opening
     */
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item', 'agent:item'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item', 'agent:item'])]
        public ?int $id,
        #[Groups(['child:item', 'child:list', 'customer:item', 'agent:item'])]
        public string $name,
        #[Groups(['child:item', 'child:list', 'customer:item', 'agent:item'])]
        public string $address,
        #[Groups(['child:item', 'child:list', 'customer:item', 'agent:item'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        /** @var array<int, NurseryStructureOpeningView> $opening */
        public array $opening,
        #[Groups(['child:item', 'child:list', 'customer:item', 'agent:item'])]
        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
