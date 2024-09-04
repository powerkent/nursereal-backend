<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Application\Shared\Query\FindNurseryStructureByUuidQuery;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class CreateAgentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private AgentRepositoryInterface $agentRepository,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(CreateAgentCommand $command): Agent
    {
        $command->primitives['updatedAt'] = null;

        $nurseryStructures = $command->primitives['nurseryStructures'];
        $password = $command->primitives['password'];
        unset($command->primitives['nurseryStructures'], $command->primitives['password']);

        $agent = new Agent(...$command->primitives);

        if (!empty($nurseryStructures)) {
            foreach ($nurseryStructures as $nurseryStructureUuid) {
                $nurseryStructure = $this->queryBus->ask(new FindNurseryStructureByUuidQuery((string) $nurseryStructureUuid->uuid));
                if (null === $nurseryStructure) {
                    throw new EntityNotFoundException(NurseryStructure::class, $nurseryStructureUuid, 'uuid');
                }
                $agent->addNurseryStructure($nurseryStructure);
                $nurseryStructure->addAgent($agent);
            }
        }

        $agent->setPassword($this->passwordHasher->hashPassword($agent, $password));

        return $this->agentRepository->save($agent);
    }
}
