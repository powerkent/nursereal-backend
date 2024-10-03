<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Exception;

use LogicException;
use Throwable;
use function sprintf;

class ActionNotEnabledTransitionException extends LogicException
{
    public function __construct(string $transitionName, string $workflowName, ?int $id, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Transition "%s" is not enabled for workflow "%s" for action id #%d.', $transitionName, $workflowName, $id), $code, $previous);
    }
}
