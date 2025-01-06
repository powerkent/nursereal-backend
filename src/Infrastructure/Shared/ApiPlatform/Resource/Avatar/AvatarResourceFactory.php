<?php

declare(strict_types=1);

namespace Avatar;

use Nursery\Domain\Shared\Model\Avatar;

final readonly class AvatarResourceFactory
{
    public function fromModel(Avatar $avatar): AvatarResource
    {
        return new AvatarResource(
            uuid: $avatar->getUuid(),
            contentUrl: $avatar->getContentUrl(),
        );
    }
}
