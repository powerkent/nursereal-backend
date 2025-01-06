<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Agent;

use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;

final readonly class FindAgentsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private AgentRepositoryInterface $agentRepository)
    {
    }

    /**
     * @return array<int, Agent>
     */
    public function __invoke(FindAgentsQuery $query): iterable
    {
        return $this->agentRepository->all();
    }
}
