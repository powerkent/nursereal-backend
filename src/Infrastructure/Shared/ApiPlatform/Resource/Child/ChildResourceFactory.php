<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Child;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Infrastructure\Shared\ApiPlatform\View\AgeGroup\AgeGroupViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Avatar\AvatarViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Family\FamilyViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\IRP\IRPViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructure\NurseryStructureViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Treatment\TreatmentView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Treatment\TreatmentViewFactory;

final readonly class ChildResourceFactory
{
    public function __construct(
        private AvatarViewFactory $avatarViewFactory,
        private AgeGroupViewFactory $ageGroupViewFactory,
        private FamilyViewFactory $familyViewFactory,
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
            avatar: null !== $child->getAvatar() ? $this->avatarViewFactory->fromModel($child->getAvatar()) : null,
            firstname: $child->getFirstname(),
            lastname: $child->getLastname(),
            birthday: $child->getBirthday(),
            gender: $child->getGender()->value,
            nurseryStructure: $this->nurseryStructureViewFactory->fromModel($child->getNurseryStructure()),
            ageGroup: null !== $child->getAgeGroup() ? $this->ageGroupViewFactory->fromModel($child->getAgeGroup()) : null,
            isWalking: $child->isWalking(),
            family: $this->familyViewFactory->fromModel($child->getFamily()),
            createdAt: $child->getCreatedAt(),
            updatedAt: $child->getUpdatedAt(),
            irp: null !== $child->getIrp() ? $this->IRPViewFactory->fromModel($child->getIrp()) : null,
            treatments: $child->getTreatments()?->map(fn (Treatment $treatment): TreatmentView => $this->treatmentViewFactory->fromModel($treatment))->getValues(),
        );
    }
}
