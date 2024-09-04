<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

/**
 * @codeCoverageIgnore
 */
final class SecurityOpenApiContext implements OpenApiContextInterface
{
    public function operations(): array
    {
        return [
            'GET /api/logout' => [
                'operation_id' => 'logout',
                'summary' => 'Allow agent to logout',
                'description' => 'Allow agent to logout',
                'responses' => [
                    204 => [
                        'description' => 'Logout are done.',
                    ],
                ],
            ],
        ];
    }
}
