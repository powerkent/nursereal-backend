<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query\Action;

use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Shared\Query\QueryInterface;

final class FindActionByTypeQuery implements QueryInterface
{
    public function __construct(public ActionType $type)
    {
    }
}
