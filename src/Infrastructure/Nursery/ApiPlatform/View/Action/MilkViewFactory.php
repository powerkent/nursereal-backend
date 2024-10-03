<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use Nursery\Domain\Nursery\Model\Action\Milk;

final class MilkViewFactory
{
    public function fromModel(Milk $milk): MilkView
    {
        return new MilkView(
            startDateTime: $milk->getStartDateTime(),
            endDateTime: $milk->getEndDateTime(),
            quantity: $milk->getQuantity(),
        );
    }
}
