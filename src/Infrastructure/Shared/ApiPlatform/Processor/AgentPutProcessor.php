<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Nursery\Application\Shared\Query\FindAgentByUuidQuery;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\AgentResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\AgentResourceFactory;

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
        $agent = $this->queryBus->ask(new FindAgentByUuidQuery($uriVariables['uuid']));

        if (null === $agent) {
            throw new EntityNotFoundException(Child::class);
        }

        $agent = $this->agentProcessor->process($data, $uriVariables['uuid'], $agent->getCreatedAt(), new DateTimeImmutable());

        return $this->agentResourceFactory->fromModel($agent);
    }
}
