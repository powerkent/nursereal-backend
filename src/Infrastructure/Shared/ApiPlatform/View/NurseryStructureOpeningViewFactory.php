<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use Nursery\Domain\Shared\Model\NurseryStructureOpening;

final class NurseryStructureOpeningViewFactory
{
    public function fromModel(NurseryStructureOpening $nurseryStructureOpening): NurseryStructureOpeningView
    {
        return new NurseryStructureOpeningView(
            openingHour: $nurseryStructureOpening->getOpeningHour()->format('H:i'),
            closingHour: $nurseryStructureOpening->getClosingHour()->format('H:i'),
            openingDay: $nurseryStructureOpening->getOpeningDay(),
        );
    }
}
