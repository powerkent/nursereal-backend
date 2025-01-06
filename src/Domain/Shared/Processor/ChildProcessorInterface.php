<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Processor;

use Nursery\Domain\Shared\Model\Child;
use Ramsey\Uuid\UuidInterface;

interface ChildProcessorInterface
{
    public function process(ChildInputDataInterface $data, UuidInterface $uuid): Child;
}
