<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Domain\Nursery\Processor\ActionInputInterface;
use Nursery\Domain\Nursery\Processor\ActionProcessorInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\ActionInput;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action\ActionResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action\ActionResourceFactory;
use Symfony\Component\HttpFoundation\InputBag;

/**
 * @implements ProcessorInterface<ActionInputInterface, ActionResource>
 */
final readonly class ActionPutProcessor implements ProcessorInterface
{
    public function __construct(
        private ActionProcessorInterface $actionProcessor,
        private ActionResourceFactory $actionResourceFactory,
    ) {
    }

    /**
     * @param ActionInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ActionResource
    {
        /** @var InputBag $query */
        /* @phpstan-ignore-next-line */
        $query = $context['request']->query;

        $action = $this->actionProcessor->process($data, $uriVariables['uuid'], $query);

        return $this->actionResourceFactory->fromModel($action);
    }
}
