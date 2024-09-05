<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use DateTimeImmutable;
use Nursery\Application\Shared\Query\FindNurseryStructureByUuidQuery;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use function dump;

final readonly class CreateOrUpdateAgentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private AgentRepositoryInterface $agentRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateAgentCommand $command): Agent
    {
        /** @var ?Agent $agent */
        $agent = $this->agentRepository->searchByUuid(!$command->primitives['uuid'] instanceof UuidInterface ? Uuid::fromString($command->primitives['uuid']) : $command->primitives['uuid']);

        $nurseryStructures = $command->primitives['nurseryStructures'];
        $password = $command->primitives['password'];

        if (null !== $agent) {
            $createdAt = $agent->getCreatedAt();
            unset($command->primitives['nurseryStructures'], $command->primitives['createdAt'], $command->primitives['updatedAt']);
            $agent = $this->normalizer->denormalize($command->primitives, Agent::class, context: ['object_to_populate' => $agent]); ;
            $agent
                ->setPassword($this->passwordHasher->hashPassword($agent, $password))
                ->setCreatedAt($createdAt)
                ->setUpdatedAt(new DateTimeImmutable());

            $this->setNurseryStructure($nurseryStructures, $agent);
            return $this->agentRepository->update($agent);
        }

        $agent = (new Agent(...$command->primitives))
            ->setPassword($this->passwordHasher->hashPassword($agent, $password))
            ->setCreatedAt(new DateTimeImmutable())
            ->setUpdatedAt(null);

        $this->setNurseryStructure($nurseryStructures, $agent);
        return $this->agentRepository->update($agent);
    }

    private function setNurseryStructure(?NurseryStructure $nurseryStructures, Agent $agent): void
    {
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
    }
}
