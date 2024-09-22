<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Cloud;

use Aws\S3\S3Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class S3Uploader
{
    public function __construct(
        private S3Client $s3Client,
        private string $bucket,
    ) {
    }

    public function uploadFile(UploadedFile $file): string
    {
        $filePath = sprintf('%s/%s', 'uploads', uniqid('', true) . '.' . $file->guessExtension());

        $this->s3Client->putObject([
            'Bucket' => $this->bucket,
            'Key'    => $filePath,
            'Body'   => fopen($file->getPathname(), 'r'),
            'ACL'    => 'public-read',
        ]);

        return $filePath;
    }
}