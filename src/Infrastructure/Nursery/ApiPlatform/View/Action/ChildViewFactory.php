<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use Nursery\Domain\Shared\Model\Child;

final class ChildViewFactory
{
    public function fromModel(Child $child): ChildView
    {
        return new ChildView(
            uuid: $child->getUuid(),
            id: $child->getId(),
            avatar: $child->getAvatar()?->getContentUrl(),
            firstname: $child->getFirstname(),
            lastname: $child->getLastname(),
        );
    }
}
