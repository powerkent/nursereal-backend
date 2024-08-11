<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use Nursery\Domain\Shared\Model\Activity;

final class ActivityResourceFactory
{
    public function fromModel(Activity $activity): ActivityResource
    {
        return new ActivityResource(
            uuid: $activity->getUuid(),
            name: $activity->getName(),
            description: $activity->getDescription(),
            createdAt: $activity->getCreatedAt(),
            updatedAt: $activity->getUpdatedAt(),
        );
    }
}
