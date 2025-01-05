<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Exception;

use LogicException;
use function sprintf;

class NotEnabledTransitionException extends LogicException
{
    public readonly object $subject;
    public readonly string $workflowName;
    public readonly string $transitionName;
    /** @var array<int, mixed> */
    public readonly array $context;

    /**
     * @param array<int, mixed> $context
     */
    public function __construct(object $subject, string $transitionName, string $workflowName, array $context = [])
    {
        parent::__construct(sprintf('Transition "%s" is not enabled for workflow "%s".', $transitionName, $workflowName));

        $this->subject = $subject;
        $this->workflowName = $workflowName;
        $this->transitionName = $transitionName;
        $this->context = $context;
    }
}
