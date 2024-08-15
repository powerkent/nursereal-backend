<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Action;

use Nursery\Domain\Shared\Model\Action\Treatment;

final class TreatmentViewFactory
{
    public function fromModel(Treatment $treatment): TreatmentView
    {
        return new TreatmentView(
            name: $treatment->getTreatment()->getName(),
            description: $treatment->getTreatment()->getDescription(),
            createdAt: $treatment->getCreatedAt(),
        );
    }
}
