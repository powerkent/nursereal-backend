<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Workflow;

use LogicException;

interface WorkflowInterface
{
    public function can(object $subject, string $transition): bool;

    /**
     * @param array<string, mixed> $context
     *
     * @throws LogicException
     */
    public function apply(object $subject, string $transition, array $context = []): void;

    public function name(object $subject): string;
}
