<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Processor;

use Nursery\Domain\Nursery\Model\Child;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\ChildInput;
use Ramsey\Uuid\UuidInterface;

interface ChildProcessorInterface
{
    public function process(ChildInput $data, UuidInterface $uuid): Child;
}
