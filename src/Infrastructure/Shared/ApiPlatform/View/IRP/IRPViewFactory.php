<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\IRP;

use Nursery\Domain\Shared\Model\IRP;

final class IRPViewFactory
{
    public function fromModel(IRP $irp): IRPView
    {
        return new IRPView(
            name: $irp->getName(),
            description: $irp->getDescription(),
            createdAt: $irp->getCreatedAt(),
            startAt: $irp->getStartAt(),
            endAt: $irp->getEndAt(),
        );
    }
}
