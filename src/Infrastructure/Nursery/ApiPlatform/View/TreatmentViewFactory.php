<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View;

use Nursery\Domain\Nursery\Model\Dosage;
use Nursery\Domain\Nursery\Model\Treatment;

final class TreatmentViewFactory
{
    public function __construct(private DosageViewFactory $dosageViewFactory)
    {
    }

    public function fromModel(Treatment $treatment): TreatmentView
    {
        return new TreatmentView(
            childUuid: $treatment->getChild()?->getUuid(),
            name: $treatment->getName(),
            description: $treatment->getDescription(),
            dosages: $treatment->getDosages()?->map(fn (Dosage $dosage): DosageView => $this->dosageViewFactory->fromModel($dosage))->toArray(),
            createdAt: $treatment->getCreatedAt(),
            startAt: $treatment->getStartAt(),
            endAt: $treatment->getEndAt(),
        );
    }
}
