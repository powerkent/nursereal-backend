<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Child;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Customer\CustomerView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Customer\CustomerViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\IRP\IRPViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructure\NurseryStructureViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Treatment\TreatmentView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Treatment\TreatmentViewFactory;

final readonly class ChildResourceFactory
{
    public function __construct(
        private CustomerViewFactory $customerViewFactory,
        private IRPViewFactory $IRPViewFactory,
        private TreatmentViewFactory $treatmentViewFactory,
        private NurseryStructureViewFactory $nurseryStructureViewFactory,
    ) {
    }

    public function fromModel(Child $child): ChildResource
    {
        return new ChildResource(
            uuid: $child->getUuid(),
            id: $child->getId(),
            avatar: $child->getAvatar()?->getContentUrl(),
            firstname: $child->getFirstname(),
            lastname: $child->getLastname(),
            birthday: $child->getBirthday(),
            nurseryStructure: $this->nurseryStructureViewFactory->fromModel($child->getNurseryStructure()),
            createdAt: $child->getCreatedAt(),
            updatedAt: $child->getUpdatedAt(),
            irp: null !== $child->getIrp() ? $this->IRPViewFactory->fromModel($child->getIrp()) : null,
            customers: $child->getCustomers()->map(fn (Customer $customer): CustomerView => $this->customerViewFactory->fromModel($customer))->getValues(),
            treatments: $child->getTreatments()?->map(fn (Treatment $treatment): TreatmentView => $this->treatmentViewFactory->fromModel($treatment))->getValues(),
        );
    }
}