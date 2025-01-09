<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Nursery\Application\Shared\Query\Agent\FindShiftTypeByUuidQuery;
use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ShiftTypeInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\ShiftTypeResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\ShiftTypeResourceFactory;

/**
 * @implements ProcessorInterface<ShiftTypeInput, ShiftTypeResource>
 */
final readonly class ShiftTypePutProcessor implements ProcessorInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ShiftTypeResourceFactory $shiftTypeResourceFactory,
        private ShiftTypeProcessor $shiftTypeProcessor,
    ) {
    }

    /**
     * @param  ShiftTypeInput $data
     * @throws Exception
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ShiftTypeResource
    {
        /** @var ?ShiftType $shiftType */
        $shiftType = $this->queryBus->ask(new FindShiftTypeByUuidQuery($uriVariables['uuid']));

        if (null === $shiftType) {
            throw new EntityNotFoundException(ShiftType::class);
        }

        $shiftType = $this->shiftTypeProcessor->process($data, $uriVariables['uuid']);

        return $this->shiftTypeResourceFactory->fromModel($shiftType);
    }
}
