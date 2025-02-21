<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\Serializer;

use Nursery\Domain\Shared\Serializer\NormalizerInterface as DomainNormalizer;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final readonly class Normalizer implements DomainNormalizer
{
    public function __construct(
        private NormalizerInterface $normalizer,
        private DenormalizerInterface $denormalizer,
    ) {
    }

    /**
     * <<<<<<< Updated upstream.
     * @param  array<string, mixed> $context
     *                                       =======
     * @param  array<string, mixed> $context
     *                                       >>>>>>> Stashed changes
     * @throws ExceptionInterface
     */
    public function normalize(mixed $data, ?string $format = null, array $context = []): mixed
    {
        return $this->normalizer->normalize($data, $format, $context);
    }

    /**
     * @template T of object
     *
     * @phpstan-param class-string<T> $type
     *
     * @param array<string, mixed> $context
     *
     * @phpstan-return T
     * @throws ExceptionInterface
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): object
    {
        return $this->denormalizer->denormalize($data, $type, $format, $context);
    }
}
