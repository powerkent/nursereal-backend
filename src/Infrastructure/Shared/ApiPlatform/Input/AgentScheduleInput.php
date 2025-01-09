<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use Symfony\Component\Serializer\Annotation\Groups;

final class AgentScheduleInput
{
    public function __construct(
        #[Groups(['agentSchedule:item'])]
        public ?string $agentUuid = null,
        #[Groups(['agentSchedule:item'])]
        public ?bool $shiftRotation = null,
        #[Groups(['agentSchedule:item'])]
        public ?string $nurseryStructureUuid = null,
        #[Groups(['agentSchedule:item'])]
        public ?string $shiftTypeUuid = null,
        #[Groups(['agentSchedule:item'])]
        public ?string $arrivalDateTime = null,
        #[Groups(['agentSchedule:item'])]
        public ?string $endOfWorkDateTime = null,
        #[Groups(['agentSchedule:item'])]
        public ?string $breakDateTime = null,
        #[Groups(['agentSchedule:item'])]
        public ?string $endOfBreakDateTime = null,
    ) {
    }
}
