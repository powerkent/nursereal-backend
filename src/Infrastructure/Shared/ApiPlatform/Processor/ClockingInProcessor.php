<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ClockingIn\ClockingInResource;
use ClockingIn\ClockingInResourceFactory;
use Exception;
use Nursery\Application\Shared\Command\ClockingIn\CreateOrUpdateClockingInCommand;
use Nursery\Application\Shared\Query\Agent\FindAgentByUuidOrIdQuery;
use Nursery\Application\Shared\Query\Config\FindConfigByUuidOrNameQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Config;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ClockingInInput;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @implements ProcessorInterface<ClockingInInput, ClockingInResource>
 */
final readonly class ClockingInProcessor implements ProcessorInterface
{
    public function __construct(
        private Security $security,
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private ClockingInResourceFactory $clockingInResourceFactory,
    ) {
    }

    /**
     * @param ClockingInInput $data
     * @throws Exception
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ClockingInResource
    {
        /** @var Agent $agent */
        $agent = $this->security->getUser();
        $config = $this->queryBus->ask(new FindConfigByUuidOrNameQuery(name: Config::AGENT_LOGIN_WITH_PHONE));
        if (!$config->getValue() && $data->agentUuid) {
            $agent = $this->queryBus->ask(new FindAgentByUuidOrIdQuery(uuid: $data->agentUuid));
        }

        $primitives = [
            'uuid' => $uriVariables['uuid'] ?? Uuid::uuid4(),
            'startDateTime' => $data->startDateTime,
            'endDateTime' => $data->endDateTime,
            'agent' => $agent,
        ];

        $clockingIn = $this->commandBus->dispatch(CreateOrUpdateClockingInCommand::create($primitives));

        return $this->clockingInResourceFactory->fromModel($clockingIn);
    }
}
