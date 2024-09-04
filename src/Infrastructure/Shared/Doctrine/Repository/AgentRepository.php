<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;

/**
 * @extends AbstractRepository<Agent>
 */
class AgentRepository extends AbstractRepository implements AgentRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Agent::class;
    }

    public function searchAgentsByNurseryStructure(NurseryStructure $nurseryStructure): array
    {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder
            ->select('a')
            ->join('a.nurseryStructures', 'ns')
            ->where($queryBuilder->expr()->eq('ns.id', ':nsId'))
            ->setParameter('nsId', $nurseryStructure->getId());

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
