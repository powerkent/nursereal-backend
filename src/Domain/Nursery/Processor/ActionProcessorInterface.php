<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Processor;

use Nursery\Domain\Nursery\Model\Action;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\InputBag;

interface ActionProcessorInterface
{
    /**
     * @param ActionInputInterface            $data
     * @param InputBag<bool|float|int|string> $query
     */
    public function process($data, UuidInterface $uuid, InputBag $query): Action;
}
