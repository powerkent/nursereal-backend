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
                        'name' => 'nurseryStructureId',
                        'in' => 'query',
                        'schema' => ['type' => 'integer'],
                    ],
                    [
                        'name' => 'childId',
                        'in' => 'query',
                        'schema' => ['type' => 'integer'],
                    ],
                    [
                        'name' => 'isToday',
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
