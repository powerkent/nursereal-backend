<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Repository;

use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\AgentSchedule;

/**
 * @extends RepositoryInterface<AgentSchedule>
 */
interface AgentScheduleRepositoryInterface extends RepositoryInterface
{
    /**
     * @return array<int, AgentSchedule>
     */
    public function searchAgentSchedulesByAgent(Agent $agent): array;
}
