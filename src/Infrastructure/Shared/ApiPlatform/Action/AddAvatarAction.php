<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Action;

use Nursery\Infrastructure\Shared\Cloud\S3Uploader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final readonly class AddAvatarAction
{
    public function __construct(
        private S3Uploader $s3Uploader,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $file = $request->files->get('file');
        if (!$file) {
            return new JsonResponse(['error' => 'No file uploaded'], 400);
        }

        $filePath = $this->s3Uploader->uploadFile($file);

        return new JsonResponse(['url' => $filePath], 201);
    }
}
