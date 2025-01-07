<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\ClockingIn;

use Nursery\Domain\Shared\Command\CommandInterface;
use Nursery\Domain\Shared\Enum\ClockingInTransition;
use Nursery\Domain\Shared\Model\ClockingIn;

final readonly class UpdateClockingInStateCommand implements CommandInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function __construct(
        public ClockingIn $clockingIn,
        public ClockingInTransition $transition,
        public array $context = [],
    ) {
    }
}
