<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Repository;

use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\NurseryStructure;

/**
 * @extends RepositoryInterface<Agent>
 */
interface AgentRepositoryInterface extends RepositoryInterface
{
    /**
     * @return array<int, Agent>
     */
    public function searchAgentsByNurseryStructure(NurseryStructure $nurseryStructure): array;
}
