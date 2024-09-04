<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Agent;
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
}
