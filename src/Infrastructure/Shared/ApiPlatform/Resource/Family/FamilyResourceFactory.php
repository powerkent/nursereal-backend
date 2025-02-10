<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Family;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Family;
use Nursery\Domain\Shared\Model\TrustedPerson;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Child\ChildView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Child\ChildViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Customer\CustomerViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Family\TrustedPersonView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Family\TrustedPersonViewFactory;

final readonly class FamilyResourceFactory
{
    public function __construct(
        private CustomerViewFactory $customerViewFactory,
        private ChildViewFactory $childViewFactory,
        private TrustedPersonViewFactory $trustedPersonViewFactory,
    ) {
    }

    public function fromModel(Family $family): FamilyResource
    {
        return new FamilyResource(
            uuid: $family->getUuid(),
            name: $family->getName(),
            customerA: $family->getCustomerA() ? $this->customerViewFactory->fromModel($family->getCustomerA()) : null,
            customerB: $family->getCustomerB() ? $this->customerViewFactory->fromModel($family->getCustomerB()) : null,
            createdAt: $family->getCreatedAt(),
            updatedAt: $family->getUpdatedAt(),
            children: $family->getChildren()->map(fn (Child $child): ChildView => $this->childViewFactory->fromModel($child))->toArray(),
            trustedPersons: $family->getTrustedPersons()->map(fn (TrustedPerson $trustedPerson): TrustedPersonView => $this->trustedPersonViewFactory->fromModel($trustedPerson))->toArray(),
        );
    }
}
