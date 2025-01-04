<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Listener;

use RuntimeException;

interface GuardInterface
{
    public function handle(object $subject): ?RuntimeException;

    /**
     * @return list<string>
     */
    public function transitions(): array;

    public function stateMachine(): string;
}
