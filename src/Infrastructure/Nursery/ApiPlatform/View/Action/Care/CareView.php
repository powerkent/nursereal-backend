<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Care;

use Nursery\Domain\Nursery\Enum\CareType;
use Symfony\Component\Serializer\Annotation\Groups;

class CareView
{
    /**
     * @param array<int, CareType> $careTypes
     */
    public function __construct(
        #[Groups(['action:item', 'action:list'])]
        /** @var array<int, CareType> $careTypes */
        public array $careTypes,
    ) {
    }
}
