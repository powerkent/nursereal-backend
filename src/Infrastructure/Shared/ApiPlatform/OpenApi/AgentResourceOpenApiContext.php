<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

/**
 * @codeCoverageIgnore
 */
final readonly class AgentResourceOpenApiContext implements OpenApiContextInterface
{
    public function operations(): array
    {
        return [
            'GET /api/agents' => [
                'parameters' => [
                    [
                        'name' => 'nursery_structure_uuid',
                        'in' => 'query',
                        'schema' => ['type' => 'string'],
                    ],
                ],
            ],
        ];
    }
}
