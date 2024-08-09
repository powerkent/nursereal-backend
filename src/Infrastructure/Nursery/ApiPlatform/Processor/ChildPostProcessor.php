<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Exception;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\ChildInput;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ChildResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ChildResourceFactory;
use Ramsey\Uuid\Uuid;

final readonly class ChildPostProcessor implements ProcessorInterface
{
    public function __construct(
        private ChildProcessor $childProcessor,
        private ChildResourceFactory $childResourceFactory,
    ) {
    }

    /**
     * @param  ChildInput $data
     * @throws Exception
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ChildResource
    {
        $child = $this->childProcessor->process($data, Uuid::uuid4());

        return $this->childResourceFactory->fromModel($child);
    }
}
