<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Care;

use Nursery\Domain\Nursery\Model\Action\Care;

final class CareViewFactory
{
    public function fromModel(Care $care): CareView
    {
        return new CareView(
            careTypes: $care->getTypes(),
        );
    }
}
