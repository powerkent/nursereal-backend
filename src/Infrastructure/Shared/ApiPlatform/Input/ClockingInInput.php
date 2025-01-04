<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

final class ClockingInInput
{
    public function __construct(
        #[Groups(['clockingIn:item'])]
        public DateTimeInterface $startDateTime,
        #[Groups(['clockingIn:item'])]
        public ?DateTimeInterface $endDateTime = null,
        #[Groups(['clockingIn:item'])]
        public ?UuidInterface $agentUuid = null,
    ) {
    }
}
