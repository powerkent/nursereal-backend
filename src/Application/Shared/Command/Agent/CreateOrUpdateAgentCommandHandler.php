<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Agent;

use DateTimeImmutable;
use Nursery\Application\Shared\Query\NurseryStructure\FindNurseryStructureByUuidQuery;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateOrUpdateAgentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private AgentRepositoryInterface $agentRepository,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateAgentCommand $command): Agent
    {
        /** @var ?Agent $agent */
        $agent = $this->agentRepository->searchByUuid(!$command->primitives['uuid'] instanceof UuidInterface ? Uuid::fromString($command->primitives['uuid']) : $command->primitives['uuid']);

        $nurseryStructures = $command->primitives['nurseryStructures'];

        if (null !== $agent) {
            $createdAt = $agent->getCreatedAt();
            unset($command->primitives['nurseryStructures'], $command->primitives['createdAt'], $command->primitives['updatedAt']);
            $agent = $this->normalizer->denormalize($command->primitives, Agent::class, context: ['object_to_populate' => $agent]);
            $agent
                ->setCreatedAt($createdAt)
                ->setUpdatedAt(new DateTimeImmutable());

            $this->setNurseryStructures($nurseryStructures, $agent);

            return $this->agentRepository->update($agent);
        }

        unset($command->primitives['nurseryStructures']);
        $agent = new Agent(...$command->primitives);
        $agent
            ->setCreatedAt(new DateTimeImmutable())
            ->setUpdatedAt(null);

        $this->setNurseryStructures($nurseryStructures, $agent);

        return $this->agentRepository->update($agent);
    }

    /**
     * @param list<string> $nurseryStructures
     */
    private function setNurseryStructures(array $nurseryStructures, Agent $agent): void
    {

        if (!empty($nurseryStructures)) {
            foreach ($nurseryStructures as $nurseryStructureUuid) {
                $nurseryStructure = $this->queryBus->ask(new FindNurseryStructureByUuidQuery(Uuid::fromString($nurseryStructureUuid)));
                if (null === $nurseryStructure) {
                    throw new EntityNotFoundException(NurseryStructure::class, $nurseryStructureUuid, 'uuid');
                }
                $agent->addNurseryStructure($nurseryStructure);
                $nurseryStructure->addAgent($agent);
            }
        }
    }
}
