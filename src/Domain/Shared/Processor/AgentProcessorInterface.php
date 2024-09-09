<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Processor;

use Nursery\Domain\Shared\Model\Agent;
use Ramsey\Uuid\UuidInterface;

interface AgentProcessorInterface
{
    public function process(AgentInputInterface $data, UuidInterface $uuid): Agent;
}
