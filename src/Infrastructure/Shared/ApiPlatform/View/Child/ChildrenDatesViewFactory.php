<?php

declare(strict_types=1);

namespace Child;

use Nursery\Domain\Shared\Model\ContractDate;

final class ChildrenDatesViewFactory
{
    public function fromModel(ContractDate $contractDate): ChildDatesView
    {
        return new ChildDatesView(
            id: $contractDate->getId(),
            contractTimeStart: $contractDate->getContractTimeStart(),
            contractTimeEnd: $contractDate->getContractTimeEnd(),
        );
    }
}
