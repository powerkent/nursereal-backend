<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Flysystem;

use League\Flysystem\FilesystemOperator;

class Storage
{
    public function __construct(private FilesystemOperator $storage)
    {
    }

    public function uploadFile(string $path, string $content): void
    {
        $this->storage->write($path, $content);
    }

    public function downloadFile(string $path): string
    {
        return $this->storage->read($path);
    }
}
