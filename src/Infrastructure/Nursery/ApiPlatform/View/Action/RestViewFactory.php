<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use Nursery\Domain\Nursery\Model\Action\Rest;

final class RestViewFactory
{
    public function fromModel(Rest $rest): RestView
    {
        return new RestView(
            startDateTime: $rest->getStartDateTime(),
            endDateTime: $rest->getEndDateTime(),
            quality: $rest->getQuality(),
        );
    }
}
