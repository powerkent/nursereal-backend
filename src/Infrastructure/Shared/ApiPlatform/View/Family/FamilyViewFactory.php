<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Family;

use Nursery\Domain\Shared\Model\Family;

final class FamilyViewFactory
{
    public function fromModel(Family $family): FamilyView
    {
        return new FamilyView(
            uuid: $family->getUuid(),
            name: $family->getName(),
            createdAt: $family->getCreatedAt(),
            updatedAt: $family->getUpdatedAt(),
        );
    }
}
