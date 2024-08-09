<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View;

use Nursery\Domain\Nursery\Model\IRP;

final class IRPViewFactory
{
    public function fromModel(IRP $irp): IRPView
    {
        return new IRPView(
            id: $irp->getId(),
            name: $irp->getName(),
            description: $irp->getDescription(),
            createdAt: $irp->getCreatedAt(),
            startAt: $irp->getStartAt(),
            endAt: $irp->getEndAt(),
        );
    }
}
