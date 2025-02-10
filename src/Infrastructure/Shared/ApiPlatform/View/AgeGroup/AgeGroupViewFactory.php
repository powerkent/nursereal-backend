<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\AgeGroup;

use Nursery\Domain\Shared\Model\AgeGroup;

final readonly class AgeGroupViewFactory
{
    public function fromModel(AgeGroup $ageGroup): AgeGroupView
    {
        return new AgeGroupView(
            uuid: $ageGroup->getUuid(),
            name: $ageGroup->getName(),
            adultChildRatio: $ageGroup->getAdultChildRatio(),
            minAge: $ageGroup->getMinAge(),
            createdAt: $ageGroup->getCreatedAt(),
            updatedAt: $ageGroup->getUpdatedAt(),
            maxAge: $ageGroup->getMaxAge(),
        );
    }
}
