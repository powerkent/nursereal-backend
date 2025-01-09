<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Agent;

use Nursery\Domain\Shared\Model\AgentSchedule;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\AgentScheduleRepositoryInterface;

final readonly class FindAgentSchedulesQueryHandler implements QueryHandlerInterface
{
    public function __construct(private AgentScheduleRepositoryInterface $agentScheduleRepository)
    {
    }

    /**
     * @return array<int, AgentSchedule>
     */
    public function __invoke(FindAgentSchedulesQuery $query): iterable
    {
        return $this->agentScheduleRepository->all();
    }
}
