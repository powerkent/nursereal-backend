<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Nursery\Application\Nursery\Query\FindChildByUuidQuery;
use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\ChildInput;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ChildResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ChildResourceFactory;

final readonly class ChildPutProcessor implements ProcessorInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ChildResourceFactory $childResourceFactory,
        private ChildProcessor $childProcessor,
    ) {
    }

    /**
     * @param  ChildInput $data
     * @throws Exception
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ChildResource
    {
        /** @var Child $child */
        $child = $this->queryBus->ask(new FindChildByUuidQuery($uriVariables['uuid']));

        if (null === $child) {
            throw new EntityNotFoundException(Child::class);
        }

        $child = $this->childProcessor->process($data, $uriVariables['uuid']);

        return $this->childResourceFactory->fromModel($child);
    }
}
