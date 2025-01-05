<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Processor;

use Nursery\Domain\Nursery\Model\Action;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\InputBag;

interface ActionProcessorInterface
{
    /**
     * @param InputBag<bool|float|int|string> $query
     */
    public function process(ActionInputInterface $data, UuidInterface $uuid, InputBag $query): Action;
}
