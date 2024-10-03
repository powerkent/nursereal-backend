<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use Nursery\Domain\Nursery\Model\Action\Diaper;

final class DiaperViewFactory
{
    public function fromModel(Diaper $diaper): DiaperView
    {
        return new DiaperView(
            diaperQuality: $diaper->getQuality(),
        );
    }
}
