<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Resource;

use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Nursery\Model\Customer;
use Nursery\Domain\Nursery\Model\Treatment;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\CustomerView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\CustomerViewFactory;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\IRPViewFactory;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\TreatmentView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\TreatmentViewFactory;

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
