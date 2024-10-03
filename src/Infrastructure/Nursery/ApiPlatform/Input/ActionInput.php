<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Input;

use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Nursery\Processor\ActionInputInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\ActivityPayload;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\CarePayload;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\DiaperPayload;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\LunchPayload;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\MilkPayload;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\PresencePayload;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\RestPayload;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\TreatmentPayload;
use Symfony\Component\Serializer\Annotation\Groups;

final class ActionInput implements ActionInputInterface
{
    public function __construct(
        #[Groups(['action:post:write'])]
        public ?string $childUuid,
        #[Groups(['action:item'])]
        public ActionType $actionType,
        #[Groups(['action:item'])]
        public ?string $comment = null,
        #[Groups(['action:item'])]
        public ?ActivityPayload $activity = null,
        #[Groups(['action:item'])]
        public ?CarePayload $care = null,
        #[Groups(['action:item'])]
        public ?DiaperPayload $diaper = null,
        #[Groups(['action:item'])]
        public ?LunchPayload $lunch = null,
        #[Groups(['action:item'])]
        public ?MilkPayload $milk = null,
        #[Groups(['action:item'])]
        public ?PresencePayload $presence = null,
        #[Groups(['action:item'])]
        public ?RestPayload $rest = null,
        #[Groups(['action:item'])]
        public ?TreatmentPayload $treatment = null,
    ) {
    }
}
