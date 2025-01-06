<?php

declare(strict_types=1);

namespace Treatment;

use Child\ChildViewFactory;
use Dosage\DosageView;
use Dosage\DosageViewFactory;
use Nursery\Domain\Shared\Model\Dosage;
use Nursery\Domain\Shared\Model\Treatment;

final readonly class TreatmentResourceFactory
{
    public function __construct(
        private ChildViewFactory $childViewFactory,
        private DosageViewFactory $dosageViewFactory,
    ) {
    }

    public function fromModel(Treatment $treatment): TreatmentResource
    {
        return new TreatmentResource(
            uuid: $treatment->getUuid(),
            child: null !== $treatment->getChild() ? $this->childViewFactory->fromModel($treatment->getChild()) : null,
            name: $treatment->getName(),
            description: $treatment->getDescription(),
            createdAt: $treatment->getCreatedAt(),
            startAt: $treatment->getStartAt(),
            endAt: $treatment->getEndAt(),
            dosages: $treatment->getDosages()->map(fn (Dosage $dosage): dosageView => $this->dosageViewFactory->fromModel($dosage))->toArray(),
        );
    }
}
