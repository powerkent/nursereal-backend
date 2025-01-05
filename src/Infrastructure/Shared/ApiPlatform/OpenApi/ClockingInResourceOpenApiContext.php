<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

/**
 * @codeCoverageIgnore
 */
final readonly class ClockingInResourceOpenApiContext implements OpenApiContextInterface
{
    public function operations(): array
    {
        return [
            'GET /api/clocking_ins' => [
                'parameters' => [
                    [
                        'name'   => 'nursery_structure_uuid',
                        'in'     => 'query',
                        'required' => true,
                        'schema' => ['type' => 'string'],
                    ],
                    [
                        'name' => 'start_date_time',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'string'],
                    ],
                    [
                        'name' => 'end_date_time',
                        'in' => 'query',
                        'schema' => ['type' => 'string'],
                    ],
                ],
            ],
        ];
    }
}
