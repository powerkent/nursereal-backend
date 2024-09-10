<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

use ApiPlatform\OpenApi\Model\RequestBody;
use ArrayObject;
use Nursery\Domain\Shared\Enum\OpeningDays;

/**
 * @codeCoverageIgnore
 */
final class NurseryStructureOpenApiContext implements OpenApiContextInterface
{
    public function __construct()
    {
    }

    public function operations(): array
    {
        return [
            'POST /api/nursery_structures' => [
                'requestBody' => new RequestBody(
                    content: new ArrayObject([
                        'application/ld+json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'name' => ['type' => 'string'],
                                    'address' => ['type' => 'string'],
                                    'openingHour' => ['type' => 'string', 'example' => '08:00'],
                                    'closingHour' => ['type' => 'string', 'example' => '19:00'],
                                    'openingDays' => [
                                        'type' => 'array',
                                        'items' => ['type' => 'string'],
                                        'example' => OpeningDays::values(),
                                    ],
                                ],
                            ],
                        ],
                    ]),
                    required: true,
                ),
            ],
            'PUT /api/nursery_structures/{uuid}' => [
                'requestBody' => new RequestBody(
                    content: new ArrayObject([
                        'application/ld+json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'name' => ['type' => 'string'],
                                    'address' => ['type' => 'string'],
                                    'openingHour' => ['type' => 'string', 'example' => '08:00'],
                                    'closingHour' => ['type' => 'string', 'example' => '19:00'],
                                    'openingDays' => [
                                        'type' => 'array',
                                        'items' => ['type' => 'string'],
                                        'example' => OpeningDays::values(),
                                    ],
                                ],
                            ],
                        ],
                    ]),
                    required: true,
                ),
            ],
        ];
    }
}
