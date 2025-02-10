<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructure;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\NurseryStructureOpening;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Address\AddressViewFactory;

final readonly class NurseryStructureViewFactory
{
    public function __construct(
        private NurseryStructureOpeningViewFactory $nurseryStructureOpeningViewFactory,
        private AddressViewFactory $addressViewFactory,
    ) {
    }

    public function fromModel(NurseryStructure $nurseryStructure): NurseryStructureView
    {
        return new NurseryStructureView(
            uuid: $nurseryStructure->getUuid(),
            id: $nurseryStructure->getId(),
            name: $nurseryStructure->getName(),
            address: $this->addressViewFactory->fromModel($nurseryStructure->getAddress()),
            createdAt: $nurseryStructure->getCreatedAt(),
            opening: $nurseryStructure->getOpenings()->map(fn (NurseryStructureOpening $opening): NurseryStructureOpeningView => $this->nurseryStructureOpeningViewFactory->fromModel($opening))->toArray(),
            updatedAt: $nurseryStructure->getUpdatedAt(),
        );
    }
}
