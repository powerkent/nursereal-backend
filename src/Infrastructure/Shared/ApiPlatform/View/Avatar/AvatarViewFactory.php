<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Avatar;

use Nursery\Domain\Shared\Model\Avatar;

final readonly class AvatarViewFactory
{
    public function fromModel(Avatar $avatar): AvatarView
    {
        return new AvatarView(
            id: $avatar->getId(),
            type: $avatar->getType()->value,
            contentUrl: $avatar->getContentUrl(),
        );
    }
}
