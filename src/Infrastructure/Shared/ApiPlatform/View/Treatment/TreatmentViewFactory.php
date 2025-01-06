<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Treatment;

use Nursery\Domain\Shared\Model\Dosage;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Dosage\DosageView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Dosage\DosageViewFactory;

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
