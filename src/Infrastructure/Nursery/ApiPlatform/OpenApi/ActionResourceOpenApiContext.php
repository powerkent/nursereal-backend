<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\OpenApi;

use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Nursery\Enum\CareType;
use Nursery\Domain\Nursery\Enum\DiaperQuality;
use Nursery\Domain\Nursery\Enum\RestQuality;
use Nursery\Infrastructure\Shared\ApiPlatform\OpenApi\OpenApiContextInterface;

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
            'POST /api/actions' => [
                'parameters' => [
                    [
                        'name' => 'action',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => ActionType::values()]],
                    ],
                    [
                        'name' => 'care[]',
                        'in' => 'query',
                        'explode' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => CareType::values()]],
                    ],
                    [
                        'name' => 'diaper',
                        'in' => 'query',
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => DiaperQuality::values()]],
                    ],
                    [
                        'name' => 'rest',
                        'in' => 'query',
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => RestQuality::values()]],
                    ],
                ],
            ],
        ];
    }
}
