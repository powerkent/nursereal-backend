<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View;

use Nursery\Domain\Nursery\Model\Dosage;

final class DosageViewFactory
{
    public function fromModel(Dosage $dosage): DosageView
    {
        return new DosageView(
            id: $dosage->getId(),
            dose: $dosage->getDose(), // quantity
            dosingDate: $dosage->getDosingDate(),
        );
    }
}
