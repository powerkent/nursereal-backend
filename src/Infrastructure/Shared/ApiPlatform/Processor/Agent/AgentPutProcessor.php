<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Nursery\Application\Shared\Query\Agent\FindAgentByUuidOrIdQuery;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\AgentResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\AgentResourceFactory;

/**
 * @implements ProcessorInterface<AgentInput, AgentResource>
 */
final readonly class AgentPutProcessor implements ProcessorInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private AgentResourceFactory $agentResourceFactory,
        private AgentProcessor $agentProcessor,
    ) {
    }

    /**
     * @param  AgentInput $data
     * @throws Exception
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): AgentResource
    {
        /** @var ?Agent $agent */
        $agent = $this->queryBus->ask(new FindAgentByUuidOrIdQuery($uriVariables['uuid']));

        if (null === $agent) {
            throw new EntityNotFoundException(Agent::class);
        }

        $agent = $this->agentProcessor->process($data, $uriVariables['uuid']);

        return $this->agentResourceFactory->fromModel($agent);
    }
}
