<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Processor;

use DateTimeInterface;
use Nursery\Domain\Shared\Model\Agent;
use Ramsey\Uuid\UuidInterface;

interface AgentProcessorInterface
{
    /**
     * @param ChildInputDataInterface $data
     */
    public function process($data, UuidInterface $uuid): Agent;
}
