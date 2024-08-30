<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use Nursery\Domain\Nursery\Model\Action\Treatment;

final class TreatmentViewFactory
{
    public function fromModel(Treatment $treatment): TreatmentView
    {
        return new TreatmentView(
            name: $treatment->getTreatment()->getName(),
            description: $treatment->getTreatment()->getDescription(),
            dose: $treatment->getDose(),
            dosingTime: $treatment->getDosingTime()?->format('H:i'),
        );
    }
}
