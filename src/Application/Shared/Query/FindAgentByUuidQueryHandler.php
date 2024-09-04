<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindAgentByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private AgentRepositoryInterface $agentRepository)
    {
    }

    final public function __invoke(FindAgentByUuidQuery $query): ?Agent
    {
        return $this->agentRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
