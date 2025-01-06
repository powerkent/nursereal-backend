<?php

declare(strict_types=1);


use Nursery\Application\Shared\Query\Agent\FindAgentsByNurseryStructureQuery;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;

final readonly class FindAgentsByNurseryStructureQueryHandler implements QueryHandlerInterface
{
    public function __construct(private AgentRepositoryInterface $agentRepository)
    {
    }

    /**
     * @return array<int, Agent>
     */
    public function __invoke(FindAgentsByNurseryStructureQuery $query): array
    {
        return $this->agentRepository->searchAgentsByNurseryStructure($query->nurseryStructure);
    }
}
