<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

use ApiPlatform\OpenApi\Model\RequestBody;
use ArrayObject;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;

/**
 * @codeCoverageIgnore
 */
final class AgentResourceFactoryOpenApiContext implements OpenApiContextInterface
{
    public function __construct()
    {
    }

    public function operations(): array
    {
        return [
            'POST /api/agents/login' => [
                'name' => "api_agents_login",
                'operation_id' => 'api_agents_login',
                'summary' => 'Create a token to connect an agent',
                'description' => 'Create a token to connect an agent',
                'requestBody'  => new RequestBody(
                    content: new ArrayObject([
                        'application/ld+json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'email' => ['type' => 'string'],
                                    'password' => ['type' => 'string'],
                                ],
                                'example' => [
                                    'email' => 'admin@example.com',
                                    'password' => 'admin',
                                ],
                            ],
                        ],
                    ]),
                ),
            ],
        ];
    }
}