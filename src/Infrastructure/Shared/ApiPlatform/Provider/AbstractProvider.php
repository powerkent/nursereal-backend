<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @template T1 of object
 * @template T2 of object
 * @implements ProviderInterface<T2>
 */
abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @param array<string, mixed> $uriVariables
     * @param array<string, mixed> $context
     *
     * @phpstan-return T1
     */
    abstract protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?object;

    /**
     * @phpstan-param T1 $model
     *
     * @phpstan-return T2
     */
    abstract protected function toResource(object $model): object;

    /**
     * @param array<string, mixed> $uriVariables
     * @param array<string, mixed> $context
     *
     * @phpstan-return T2
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?object
    {
        $model = $this->item($operation, $uriVariables, $context);

        return null !== $model ? $this->toResource($model) : null;
    }
}
