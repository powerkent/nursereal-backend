<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\NurseryStructureOpening;

final class NurseryStructureViewFactory
{
    public function __construct(private NurseryStructureOpeningViewFactory $nurseryStructureOpeningViewFactory)
    {
    }

    public function fromModel(NurseryStructure $nurseryStructure): NurseryStructureView
    {
        return new NurseryStructureView(
            uuid: $nurseryStructure->getUuid(),
            id: $nurseryStructure->getId(),
            name: $nurseryStructure->getName(),
            address: $nurseryStructure->getAddress(),
            createdAt: $nurseryStructure->getCreatedAt(),
            updatedAt: $nurseryStructure->getUpdatedAt(),
            opening: $nurseryStructure->getNurseryStructureOpenings()->map(fn (NurseryStructureOpening $opening): NurseryStructureOpeningView => $this->nurseryStructureOpeningViewFactory->fromModel($opening))->toArray(),
        );
    }
}
