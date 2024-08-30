<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

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
