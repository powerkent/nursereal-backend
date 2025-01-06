<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Diaper;

use Nursery\Domain\Nursery\Enum\DiaperQuality;
use Symfony\Component\Serializer\Annotation\Groups;

class DiaperView
{
    public function __construct(
        #[Groups(['action:item', 'action:list'])]
        public DiaperQuality $diaperQuality,
    ) {
    }
}
