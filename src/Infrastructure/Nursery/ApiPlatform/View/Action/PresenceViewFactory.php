<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use Nursery\Domain\Nursery\Model\Action\Presence;

final class PresenceViewFactory
{
    public function fromModel(Presence $presence): PresenceView
    {
        return new PresenceView(
            startDateTime: $presence->getStartDateTime(),
            endDateTime: $presence->getEndDateTime(),
            isAbsent: $presence->isAbsent(),
        );
    }
}
