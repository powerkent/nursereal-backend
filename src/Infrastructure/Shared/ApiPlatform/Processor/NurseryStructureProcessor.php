<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateMalformedStringException;
use DateTimeImmutable;
use Nursery\Application\Shared\Command\CreateOrUpdateAgentCommand;
use Nursery\Application\Shared\Command\CreateOrUpdateNurseryStructureCommand;
use Nursery\Application\Shared\Query\FindAgentsByNurseryStructureQuery;
use Nursery\Application\Shared\Query\FindConfigByUuidOrNameQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Enum\OpeningDays;
use Nursery\Domain\Shared\Model\Config;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\NurseryStructureInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructureResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructureResourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<NurseryStructureInput, NurseryStructureResource>
 */
final readonly class NurseryStructureProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private NurseryStructureResourceFactory $nurseryStructureResourceFactory,
    ) {
    }

    /**
     * @param  NurseryStructureInput        $data
     * @throws DateMalformedStringException
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): NurseryStructureResource
    {
        $primitives = [
            'uuid' => $uriVariables['uuid'] ?? Uuid::uuid4(),
            'name' => $data->name,
            'address' => $data->address,
        ];
        foreach ($data->openings as $opening) {
            $primitives['openings'][] = [
                'openingHour' => new DateTimeImmutable($opening->openingHour),
                'closingHour' => new DateTimeImmutable($opening->closingHour),
                'openingDay' => OpeningDays::from($opening->openingDay),
            ];
        }

        $nurseryStructure = $this->commandBus->dispatch(CreateOrUpdateNurseryStructureCommand::create($primitives));

        /* @var Config $config */
        $config = $this->queryBus->ask(new FindConfigByUuidOrNameQuery(name: Config::AGENT_LOGIN_WITH_PHONE));
        if (!$config->getValue() && isset($data->user) && isset($data->password)) {
            $agents = $this->queryBus->ask(new FindAgentsByNurseryStructureQuery($nurseryStructure));
            $primitives = [
                'uuid' => empty($agents) ? Uuid::uuid4() : $agents[0]->getUuid(),
                'avatar' => null,
                'firstname' => null,
                'lastname' => null,
                'email' => null,
                'user' => $data->user,
                'password' => $data->password,
                'createdAt' => empty($agents) ? new DateTimeImmutable() : $agents[0]->getCreatedAt(),
                'updatedAt' => empty($agents) ? null : new DateTimeImmutable(),
                'nurseryStructures' => [$nurseryStructure->getUuid()],
            ];

            $this->commandBus->dispatch(CreateOrUpdateAgentCommand::create($primitives));
        }

        return $this->nurseryStructureResourceFactory->fromModel($nurseryStructure);
    }
}
