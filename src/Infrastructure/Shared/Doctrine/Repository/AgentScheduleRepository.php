<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\AgentSchedule;
use Nursery\Domain\Shared\Repository\AgentScheduleRepositoryInterface;

/**
 * @extends AbstractRepository<AgentSchedule>
 */
class AgentScheduleRepository extends AbstractRepository implements AgentScheduleRepositoryInterface
{
    protected static function entityClass(): string
    {
        return AgentSchedule::class;
    }

    public function searchAgentSchedulesByAgent(Agent $agent): array
    {
        $queryBuilder = $this->createQueryBuilder('as');
        $queryBuilder
            ->select('as')
            ->join('as.agent', 'a')
            ->where($queryBuilder->expr()->eq('a.id', ':aId'))
            ->setParameter('aId', $agent->getId());

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
