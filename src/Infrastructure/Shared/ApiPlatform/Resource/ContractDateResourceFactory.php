<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildDatesView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildrenDatesViewFactory;

final readonly class ContractDateResourceFactory
{
    public function __construct(private ChildrenDatesViewFactory $childrenDatesViewFactory)
    {
    }

    public function fromModel(Child $child): ContractDateResource
    {
        return new ContractDateResource(
            childUuid : $child->getUuid(),
            avatar: $child->getAvatar()?->getContentUrl(),
            firstname : $child->getFirstname(),
            lastname  : $child->getLastname(),
            childDates: $child->getContractDates()->map(fn (ContractDate $contractDate): ChildDatesView => $this->childrenDatesViewFactory->fromModel($contractDate))->toArray(),
        );
    }
}
