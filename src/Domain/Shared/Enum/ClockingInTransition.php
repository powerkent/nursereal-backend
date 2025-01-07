<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Enum;

enum ClockingInTransition: string
{
    case InProgress = 'in_progress';
    case Completed = 'completed';
}
