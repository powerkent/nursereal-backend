<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Storage;

interface StorageInterface
{
    public function upload(string $path, string $content): void;

    public function uploadStream(string $filename, mixed $stream): void;

    public function download(string $path): string;
}
