<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Agent;

use Nursery\Domain\Shared\Model\AgentSchedule;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\AgentScheduleRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindAgentScheduleByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private AgentScheduleRepositoryInterface $agentScheduleRepository)
    {
    }

    final public function __invoke(FindAgentScheduleByUuidQuery $query): ?AgentSchedule
    {
        return $this->agentScheduleRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
