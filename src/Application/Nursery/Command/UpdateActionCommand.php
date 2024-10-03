<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Command\CommandInterface;

final class UpdateActionCommand implements CommandInterface
{
    public function __construct(public Action $action)
    {
    }
}
