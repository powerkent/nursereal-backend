<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Action;

use Nursery\Domain\Nursery\Model\Child;

final class ChildViewFactory
{
    public function fromModel(Child $child): ChildView
    {
        return new ChildView(
            uuid: $child->getUuid(),
            firstname: $child->getFirstname(),
            lastname: $child->getLastname(),
        );
    }
}
