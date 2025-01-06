<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Agent;

use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindAgentByUuidOrIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private AgentRepositoryInterface $agentRepository)
    {
    }

    final public function __invoke(FindAgentByUuidOrIdQuery $query): ?Agent
    {
        if (null !== $query->id) {
            return $this->agentRepository->search($query->id);
        }

        if (null === $query->uuid) {
            return null;
        }

        return $this->agentRepository->searchByUuid(
            $query->uuid instanceof UuidInterface
                ? $query->uuid
                : Uuid::fromString($query->uuid)
        );
    }
}
