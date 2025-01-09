<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

/**
 * @codeCoverageIgnore
 */
final readonly class AgentScheduleResourceOpenApiContext implements OpenApiContextInterface
{
    public function operations(): array
    {
        return [
            'GET /api/agent_schedules' => [
                'parameters' => [
                    [
                        'name' => 'agent_uuid',
                        'in' => 'query',
                        'schema' => ['type' => 'string'],
                    ],
                ],
            ],
        ];
    }
}
