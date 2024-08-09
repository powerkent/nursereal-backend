<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

interface OpenApiContextInterface
{
    /**
     * @return array<string, mixed>
     */
    public function operations(): array;
}
