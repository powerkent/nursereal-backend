<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Serializer;

interface NormalizerInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function normalize(mixed $data, ?string $format = null, array $context = []): mixed;

    /**
     * @template T of object
     *
     * @phpstan-param class-string<T> $type
     *
     * @param array<string, mixed> $context
     *
     * @phpstan-return T
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): object;
}
