<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use Nursery\Domain\Shared\Model\Dosage;
use Nursery\Domain\Shared\Model\Treatment;

final readonly class TreatmentViewFactory
{
    public function __construct(private DosageViewFactory $dosageViewFactory)
    {
    }

    public function fromModel(Treatment $treatment): TreatmentView
    {
        return new TreatmentView(
            uuid: $treatment->getUuid(),
            childUuid: $treatment->getChild()?->getUuid(),
            name: $treatment->getName(),
            description: $treatment->getDescription(),
            createdAt: $treatment->getCreatedAt(),
            startAt: $treatment->getStartAt(),
            endAt: $treatment->getEndAt(),
            dosages: $treatment->getDosages()->map(fn (Dosage $dosage): DosageView => $this->dosageViewFactory->fromModel($dosage))->toArray(),
        );
    }
}
