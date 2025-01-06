<?php

declare(strict_types=1);

namespace Child;

use IRP\IRPViewFactory;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Treatment;
use Treatment\TreatmentView;
use Treatment\TreatmentViewFactory;

final readonly class ChildViewFactory
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
