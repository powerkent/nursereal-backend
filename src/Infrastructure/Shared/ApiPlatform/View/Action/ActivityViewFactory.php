<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Action;

use Nursery\Domain\Shared\Model\Action\Activity;

final class ActivityViewFactory
{
    public function fromModel(Activity $activity): ActivityView
    {
        return new ActivityView(
            uuid: $activity->getUuid(),
            name: $activity->getActivity()->getName(),
            description: $activity->getActivity()->getDescription(),
            comment: $activity->getComment(),
            createdAt: $activity->getCreatedAt(),
        );
    }
}
