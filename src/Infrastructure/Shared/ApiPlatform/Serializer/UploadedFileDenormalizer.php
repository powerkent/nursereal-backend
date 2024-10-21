<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Serializer;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class UploadedFileDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $type, ?string $format = null, array $context = []): File
    {
        return $data;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $data instanceof File;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => null,
            '*' => false,
            File::class => true,
        ];
    }
}
