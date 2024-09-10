<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\NurseryStructureOpening;
use function array_map;

final class NurseryStructureViewFactory
{
    public function __construct(private NurseryStructureOpeningViewFactory $nurseryStructureOpeningViewFactory)
    {
    }

    public function fromModel(NurseryStructure $nurseryStructure): NurseryStructureView
    {
        return new NurseryStructureView(
            uuid: $nurseryStructure->getUuid(),
            name: $nurseryStructure->getName(),
            address: $nurseryStructure->getAddress(),
            createdAt: $nurseryStructure->getCreatedAt(),
            updatedAt: $nurseryStructure->getUpdatedAt(),
            opening: array_map(fn (NurseryStructureOpening $opening): NurseryStructureOpeningView => $this->nurseryStructureOpeningViewFactory->fromModel($opening), $nurseryStructure->getNurseryStructureOpenings()->toArray()),
        );
    }
}
