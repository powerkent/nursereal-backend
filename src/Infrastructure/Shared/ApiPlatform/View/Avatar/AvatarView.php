<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Avatar;

use Symfony\Component\Serializer\Annotation\Groups;

class AvatarView
{
    public function __construct(
        #[Groups(['customer:item', 'customer:list', 'family:item', 'family:list', 'nurseryStructure:item', 'nurseryStructure:list'])]
        public ?int $id,
        #[Groups(['customer:item', 'customer:list', 'family:item', 'family:list', 'nurseryStructure:item', 'nurseryStructure:list'])]
        public string $type,
        #[Groups(['customer:item', 'customer:list', 'family:item', 'family:list', 'nurseryStructure:item', 'nurseryStructure:list'])]
        public string $contentUrl,
    ) {
    }
}
