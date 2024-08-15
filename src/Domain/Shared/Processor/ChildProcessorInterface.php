<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Processor;

use Nursery\Domain\Shared\Model\Child;
use Ramsey\Uuid\UuidInterface;

interface ChildProcessorInterface
{
    /**
     * @param ChildInputDataInterface $data
     */
    public function process($data, UuidInterface $uuid): Child;
}
