<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Symfony\Workflow;

use Nursery\Domain\Nursery\Workflow\WorkflowInterface;
use Symfony\Component\Workflow\Exception\NotEnabledTransitionException;
use Symfony\Component\Workflow\Registry;
use Nursery\Domain\Nursery\Exception\NotEnabledTransitionException as DomainNotEnabledTransitionException;

final readonly class Workflow implements WorkflowInterface
{
    public function __construct(private Registry $registry)
    {
    }

    public function can(object $subject, string $transition): bool
    {
        return $this->registry->get($subject)->can($subject, $transition);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function apply(object $subject, string $transition, array $context = []): void
    {
        try {
            $this->registry->get($subject)->apply($subject, $transition, $context);
        } catch (NotEnabledTransitionException $exception) {
            throw new DomainNotEnabledTransitionException($subject, $exception->getTransitionName(), $exception->getWorkflow()->getName(), $exception->getContext());
        }
    }

    public function name(object $subject): string
    {
        return $this->registry->get($subject)->getName();
    }
}
