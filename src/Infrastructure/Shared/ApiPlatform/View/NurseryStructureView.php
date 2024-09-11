<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class NurseryStructureView
{
    /**
     * @param list<NurseryStructureOpeningView>|null $opening
     */
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item', 'agent:item'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item', 'agent:item'])]
        public string $name,
        #[Groups(['child:item', 'child:list', 'customer:item', 'agent:item'])]
        public string $address,
        #[Groups(['child:item', 'child:list', 'customer:item', 'agent:item'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item', 'agent:item'])]
        public ?DateTimeInterface $updatedAt = null,
        #[Groups(['child:item', 'child:list', 'customer:item', 'agent:item'])]
        /** @var list<NurseryStructureOpeningView>|null $opening */
        public ?array $opening = null,
    ) {
    }
}
