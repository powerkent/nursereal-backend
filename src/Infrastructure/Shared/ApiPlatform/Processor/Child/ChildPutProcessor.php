<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Child;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Nursery\Application\Shared\Query\Child\FindChildByUuidOrIdQuery;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ChildInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Child\ChildResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Child\ChildResourceFactory;

/**
 * @implements ProcessorInterface<ChildInput, ChildResource>
 */
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
        /** @var ?Child $child */
        $child = $this->queryBus->ask(new FindChildByUuidOrIdQuery($uriVariables['uuid']));

        if (null === $child) {
            throw new EntityNotFoundException(Child::class);
        }

        $child = $this->childProcessor->process($data, $uriVariables['uuid']);

        return $this->childResourceFactory->fromModel($child);
    }
}
