<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use Nursery\Domain\Shared\Model\NurseryStructure;

final class NurseryStructureViewFactory
{
    public function fromModel(NurseryStructure $nurseryStructure): NurseryStructureView
    {
        return new NurseryStructureView(
            uuid: $nurseryStructure->getUuid(),
            name: $nurseryStructure->getName(),
            address: $nurseryStructure->getAddress(),
            createdAt: $nurseryStructure->getCreatedAt(),
            updatedAt: $nurseryStructure->getUpdatedAt(),
            startAt: $nurseryStructure->getStartAt(),
        );
    }
}
