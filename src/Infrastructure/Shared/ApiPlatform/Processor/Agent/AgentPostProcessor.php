<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Exception;
use Nursery\Domain\Shared\Processor\AgentInputInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\AgentResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\AgentResourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<AgentInputInterface, AgentResource>
 */
final readonly class AgentPostProcessor implements ProcessorInterface
{
    public function __construct(
        private AgentProcessor $agentProcessor,
        private AgentResourceFactory $agentResourceFactory,
    ) {
    }

    /**
     * @param  AgentInput $data
     * @throws Exception
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): AgentResource
    {
        $agent = $this->agentProcessor->process($data, Uuid::uuid4());

        return $this->agentResourceFactory->fromModel($agent);
    }
}
