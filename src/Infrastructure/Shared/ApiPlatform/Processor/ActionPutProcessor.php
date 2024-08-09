<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ActionResource;

final readonly class ActionPutProcessor implements ProcessorInterface
{
    public function __construct(
    ) {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ActionResource
    {
    }
}
