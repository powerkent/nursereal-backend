<?php

declare(strict_types=1);

namespace Dosage;

use Nursery\Domain\Shared\Model\Dosage;

final class DosageViewFactory
{
    public function fromModel(Dosage $dosage): DosageView
    {
        return new DosageView(
            dose: $dosage->getDose(), // quantity
            dosingTime: $dosage->getDosingTime()?->format('H:i'),
        );
    }
}
