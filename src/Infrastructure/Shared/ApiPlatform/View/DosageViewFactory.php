<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use Nursery\Domain\Shared\Model\Dosage;

final class DosageViewFactory
{
    public function fromModel(Dosage $dosage): DosageView
    {
        return new DosageView(
            dose: $dosage->getDose(), // quantity
            dosingDate: $dosage->getDosingDate()?->format('H:i'),
        );
    }
}
