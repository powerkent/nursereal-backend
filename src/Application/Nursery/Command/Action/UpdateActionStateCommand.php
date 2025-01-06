<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command\Action;

use Nursery\Domain\Nursery\Enum\ActionTransition;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Command\CommandInterface;

final readonly class UpdateActionStateCommand implements CommandInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function __construct(
        public Action $action,
        public ActionTransition $transition,
        public array $context = [],
    ) {
    }
}
