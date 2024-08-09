<?php

declare(strict_types=1);

namespace Nursery\Nursery\Infrastructure\Shared\Symfony\Serializer;

use Nursery\Domain\Shared\Serializer\SerializerInterface as DomainSerializer;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class Serializer implements DomainSerializer
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function serialize(mixed $data, ?string $format = null, array $context = []): mixed
    {
        return $this->serializer->serialize($data, $format, $context);
    }

    /**
     * @template T of object
     *
     * @phpstan-param class-string<T> $type
     *
     * @param array<string, mixed> $context
     *
     * @phpstan-return T
     */
    public function deserialize(mixed $data, string $type, ?string $format = null, array $context = []): object
    {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }
}
