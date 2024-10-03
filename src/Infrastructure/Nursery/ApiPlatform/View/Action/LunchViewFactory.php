<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use Nursery\Domain\Nursery\Model\Action\Lunch;

final class LunchViewFactory
{
    public function fromModel(Lunch $lunch): LunchView
    {
        return new LunchView(
            startDateTime: $lunch->getStartDateTime(),
            endDateTime: $lunch->getEndDateTime(),
            lunchQuality: $lunch->getQuality(),
        );
    }
}
