<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Paths;
use ApiPlatform\OpenApi\OpenApi;

final class OpenApiFactory implements OpenApiFactoryInterface
{
    public function __construct(private OpenApiFactoryInterface $decorated)
    {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        $paths = new Paths();
        foreach ($openApi->getPaths()->getPaths() as $path => $pathItem) {
            $paths->addPath($path, $pathItem);
        }

        return $openApi->withPaths($paths);
    }
}
