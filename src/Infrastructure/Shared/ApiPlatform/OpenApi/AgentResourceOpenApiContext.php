<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

use ApiPlatform\OpenApi\Model\RequestBody;
use ArrayObject;

/**
 * @codeCoverageIgnore
 */
final readonly class AgentResourceOpenApiContext implements OpenApiContextInterface
{
    public function operations(): array
    {
        return [
            'POST /api/agents/{uuid}/avatar' => [
                'requestBody' => new RequestBody(
                    description: 'Add avatar for the agent',
                    content: new ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
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