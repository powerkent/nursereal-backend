<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use Nursery\Application\Shared\Query\FindChildreByNuseryStructueQuery;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildViewFactory;

final readonly class NurseryStructureResourceFactory
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ChildViewFactory $childViewFactory,
    ) {
    }

    public function fromModel(NurseryStructure $nurseryStructure): NurseryStructureResource
    {
        $children = $this->queryBus->ask(new FindChildreByNuseryStructueQuery($nurseryStructure));
        dump(array_map(fn (Child $child): ChildView => $this->childViewFactory->fromModel($child), $children));

        return new NurseryStructureResource(
            uuid: $nurseryStructure->getUuid(),
            name: $nurseryStructure->getName(),
            address: $nurseryStructure->getAddress(),
            createdAt: $nurseryStructure->getCreatedAt(),
            updatedAt: $nurseryStructure->getUpdatedAt(),
            startAt: $nurseryStructure->getStartAt(),
            endAt: $nurseryStructure->getEndAt(),
            children: array_map(fn (Child $child): ChildView => $this->childViewFactory->fromModel($child), $children),
        );
    }
}
