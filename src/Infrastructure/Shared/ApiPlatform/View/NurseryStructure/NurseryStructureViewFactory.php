<?php

declare(strict_types=1);

namespace NurseryStructure;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\NurseryStructureOpening;

final readonly class NurseryStructureViewFactory
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
            opening: $nurseryStructure->getNurseryStructureOpenings()->map(fn (NurseryStructureOpening $opening): NurseryStructureOpeningView => $this->nurseryStructureOpeningViewFactory->fromModel($opening))->toArray(),
            updatedAt: $nurseryStructure->getUpdatedAt(),
        );
    }
}
