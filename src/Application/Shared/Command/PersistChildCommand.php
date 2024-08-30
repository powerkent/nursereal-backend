<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Command\CommandInterface;
use Nursery\Domain\Shared\Model\Child;

final readonly class PersistChildCommand implements CommandInterface
{
    public function __construct(public Child $child)
    {
    }
}
