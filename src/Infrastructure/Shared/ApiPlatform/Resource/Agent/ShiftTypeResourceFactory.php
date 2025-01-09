<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructure\NurseryStructureView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructure\NurseryStructureViewFactory;

final readonly class ShiftTypeResourceFactory
{
    public function __construct(private NurseryStructureViewFactory $nurseryStructureViewFactory)
    {
    }

    public function fromModel(ShiftType $shiftType): ShiftTypeResource
    {
        return new ShiftTypeResource(
            uuid: $shiftType->getUuid(),
            id: $shiftType->getId(),
            name: $shiftType->getName(),
            arrivalTime: $shiftType->getArrivalTime()->format('H:i'),
            endOfWorkTime: $shiftType->getEndOfWorkTime()->format('H:i'),
            breakTime: $shiftType->getBreakTime()->format('H:i'),
            endOfBreakTime: $shiftType->getEndOfBreakTime()->format('H:i'),
            nurseryStructures: $shiftType->getNurseryStructures()->map(fn (NurseryStructure $nurseryStructure): NurseryStructureView => $this->nurseryStructureViewFactory->fromModel($nurseryStructure))->toArray(),
        );
    }
}
