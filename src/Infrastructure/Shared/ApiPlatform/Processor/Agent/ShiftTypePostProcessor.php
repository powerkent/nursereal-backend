<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Exception;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ShiftTypeInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\ShiftTypeResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\ShiftTypeResourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<ShiftTypeInput, ShiftTypeResource>
 */
final readonly class ShiftTypePostProcessor implements ProcessorInterface
{
    public function __construct(
        private ShiftTypeProcessor $shiftTypeProcessor,
        private ShiftTypeResourceFactory $shiftTypeResourceFactory,
    ) {
    }

    /**
     * @param  ShiftTypeInput $data
     * @throws Exception
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ShiftTypeResource
    {
        $agent = $this->shiftTypeProcessor->process($data, Uuid::uuid4());

        return $this->shiftTypeResourceFactory->fromModel($agent);
    }
}
