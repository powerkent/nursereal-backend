<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Child;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Exception;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ChildInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Child\ChildResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Child\ChildResourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<ChildInput, ChildResource>
 */
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
