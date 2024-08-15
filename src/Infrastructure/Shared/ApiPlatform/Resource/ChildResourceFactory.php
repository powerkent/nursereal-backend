<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Infrastructure\Shared\ApiPlatform\View\CustomerView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\CustomerViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\IRPViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\TreatmentView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\TreatmentViewFactory;

class ChildResourceFactory
{
    public function __construct(
        private CustomerViewFactory $customerViewFactory,
        private IRPViewFactory $IRPViewFactory,
        private TreatmentViewFactory $treatmentViewFactory,
        //        private ActivityViewFactory $activityViewFactory,
    ) {
    }

    public function fromModel(Child $child): ChildResource
    {
        return new ChildResource(
            uuid: $child->getUuid(),
            firstname: $child->getFirstname(),
            lastname: $child->getLastname(),
            birthday: $child->getBirthday(),
            createdAt: $child->getCreatedAt(),
            irp: null !== $child->getIrp() ? $this->IRPViewFactory->fromModel($child->getIrp()) : null,
            customers: $child->getCustomers()->map(fn (Customer $customer): CustomerView => $this->customerViewFactory->fromModel($customer))->toArray(),
            treatments: $child->getTreatments()?->map(fn (Treatment $treatment): TreatmentView => $this->treatmentViewFactory->fromModel($treatment))->toArray(),
            //            activities: $child->getActivities()?->map(fn (Activity $activity): ActivityView => $this->activityViewFactory->fromModel($activity))->toArray(),
        );
    }
}
