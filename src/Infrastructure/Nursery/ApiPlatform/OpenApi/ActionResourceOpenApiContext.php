<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\OpenApi;

use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\OpenApi\OpenApiContextInterface;

/**
 * @codeCoverageIgnore
 */
final class ActionResourceOpenApiContext implements OpenApiContextInterface
{
    public function __construct(private ChildRepositoryInterface $childRepository)
    {
    }

    public function operations(): array
    {
        $children = $this->childRepository->all();
        $childrenValues = [];
        foreach ($children as $child) {
            $childrenValues[] = $child->getId().': '.$child->getFirstname().' '.$child->getLastname();
        }

        return [
            'GET /api/actions' => [
                'parameters' => [
                    [
                        'name' => 'action[]',
                        'in' => 'query',
                        'explode' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => ActionType::values()]],
                    ],
                    [
                        'name' => 'children[]',
                        'in' => 'query',
                        'explode' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => $childrenValues]],
                    ],
                ],
            ],
        ];
    }
}
