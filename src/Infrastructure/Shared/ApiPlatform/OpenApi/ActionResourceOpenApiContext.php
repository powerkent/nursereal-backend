<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

use Enum\ActionType;

/**
 * @codeCoverageIgnore
 */
final class ActionResourceOpenApiContext implements OpenApiContextInterface
{
    public function operations(): array
    {
        return [
            'GET /api/actions' => [
                'parameters' => [
                    [
                        'name' => 'action[]',
                        'in' => 'query',
                        'explode' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => ActionType::values()]],
                    ],
                ],
            ],
        ];
    }
}
