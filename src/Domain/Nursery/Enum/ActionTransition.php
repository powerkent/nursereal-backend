<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Enum;

enum ActionTransition: string
{
    case ActionInProgress = 'action_in_progress';
    case ActionCompleted = 'action_completed';
}
