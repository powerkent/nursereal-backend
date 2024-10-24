<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

use ApiPlatform\OpenApi\Model\RequestBody;
use ArrayObject;

/**
 * @codeCoverageIgnore
 */
final readonly class ContractDateResourceOpenApiContext implements OpenApiContextInterface
{
    public function operations(): array
    {
        return [
            'GET /api/contract_dates' => [
                'parameters' => [
                    [
                        'name' => 'nursery_structure_uuid',
                        'in' => 'query',
                        'schema' => ['type' => 'string'],
                    ],
                    [
                        'name' => 'child_uuid',
                        'in' => 'query',
                        'schema' => ['type' => 'string'],
                    ],
                    [
                        'name' => 'is_today',
                        'in' => 'query',
                        'schema' => ['type' => 'boolean'],
                    ],
                ],
            ],
            'DELETE /api/contract_dates' => [
                'requestBody'  => new RequestBody(
                    content: new ArrayObject([
                        'application/ld+json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'contractDates' => [
                                        'type' => 'array',
                                        'items' => ['type' => 'integer'],
                                    ],
                                ],
                                'example' => [
                                    'contractDates' => [1, 2, 3],
                                ],
                            ],
                        ],
                    ]),
                ),
            ],
        ];
    }
}
