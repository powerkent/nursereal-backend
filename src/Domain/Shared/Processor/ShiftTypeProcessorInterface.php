<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Processor;

use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ShiftTypeInput;
use Ramsey\Uuid\UuidInterface;

interface ShiftTypeProcessorInterface
{
    public function process(ShiftTypeInput $data, UuidInterface $uuid): ShiftType;
}
