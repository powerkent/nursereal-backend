<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Avatar;

use Nursery\Domain\Shared\Model\Avatar;

final readonly class AvatarResourceFactory
{
    public function fromModel(Avatar $avatar): AvatarResource
    {
        return new AvatarResource(
            id: $avatar->getId(),
            type: $avatar->getType(),
            contentUrl: $avatar->getContentUrl(),
        );
    }
}
