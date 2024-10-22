<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Serializer;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

class MultipartDenormalizer implements DenormalizerInterface
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed                $data    Data to restore
     * @param string               $type    The expected class to instantiate
     * @param string|null          $format  Format the given data was extracted from
     * @param array<string, mixed> $context Options available to the denormalizer
     *
     * @return mixed The denormalized object
     *
     * @throws UnexpectedValueException if the data cannot be denormalized
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $request = $this->requestStack->getCurrentRequest();
        $uploadedFile = $request?->files->get('file');
        if (!$uploadedFile) {
            throw new UnexpectedValueException('No file provided in the multipart request.');
        }

        $dto = new $type();
        /* @phpstan-ignore-next-line */
        $dto->file = $uploadedFile;

        return $dto;
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed       $data   Data to denormalize from
     * @param string      $type   The class to which the data should be denormalized
     * @param string|null $format The format being deserialized from
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return 'multipart' === $format && 'Nursery\Infrastructure\Shared\ApiPlatform\Input\AvatarInput' === $type;
    }

    /**
     * Returns the types potentially supported by this denormalizer.
     *
     * @param string|null $format The format being deserialized from
     *
     * @return array<class-string|'*'|'object'|string, bool|null>
     */
    public function getSupportedTypes(?string $format): array
    {
        if ('multipart' === $format) {
            return [
                'Nursery\Infrastructure\Shared\ApiPlatform\Input\AvatarInput' => true,
                'object' => null,
            ];
        }

        return [];
    }
}
