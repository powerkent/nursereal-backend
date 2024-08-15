<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View;

use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Nursery\Model\Treatment;

final class ChildViewFactory
{
    public function __construct(
        private IRPViewFactory $IRPViewFactory,
        private TreatmentViewFactory $treatmentViewFactory,
    ) {
    }

    public function fromModel(Child $child): ChildView
    {
        return new ChildView(
            uuid: $child->getUuid(),
            firstname: $child->getFirstname(),
            lastname: $child->getLastname(),
            birthday: $child->getBirthday(),
            createdAt: $child->getCreatedAt(),
            irp: null !== $child->getIrp() ? $this->IRPViewFactory->fromModel($child->getIrp()) : null,
            treatments: $child->getTreatments()?->map(fn (Treatment $treatment): TreatmentView => $this->treatmentViewFactory->fromModel($treatment))->toArray(),
        );
    }
}
