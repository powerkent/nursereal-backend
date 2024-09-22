<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\Decoder;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MultipartDecoder implements DecoderInterface
{
    public function decode(string $data, string $format, array $context = []): array
    {
        $decodedData = [];
        foreach ($_POST as $key => $value) {
            $decodedData[$key] = $value;
        }

        foreach ($_FILES as $key => $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $uploadedFile = new UploadedFile(
                    $file['tmp_name'],
                    $file['name'],
                    $file['type'],
                    $file['size']
                );
                $decodedData[$key] = $uploadedFile;
            }
        }

        return $decodedData;
    }

    public function supportsDecoding(string $format): bool
    {
        return $format === 'multipart';
    }
}