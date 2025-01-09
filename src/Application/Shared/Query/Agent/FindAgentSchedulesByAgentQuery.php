<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Agent;

use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Query\QueryInterface;

final class FindAgentSchedulesByAgentQuery implements QueryInterface
{
    public function __construct(public Agent $agent)
    {
    }
}
