<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;

final readonly class CreateAgentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AgentRepositoryInterface $agentRepository,
    ) {
    }

    public function __invoke(CreateAgentCommand $command): Agent
    {
        $command->primitives['updatedAt'] = null;

        $agent = new Agent(...$command->primitives);

        return $this->agentRepository->save($agent);
    }
}
