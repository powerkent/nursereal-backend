<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;

/**
 * @codeCoverageIgnore
 */
final class TreatmentResourceOpenApiContext implements OpenApiContextInterface
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
            'GET /api/treatments' => [
                'parameters' => [
                    [
                        'name' => 'children[]',
                        'in' => 'query',
                        'explode' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => $childrenValues]],
                    ],
                ],
            ],
            'POST /api/treatments' => [
                'parameters' => [
                    [
                        'name' => 'childUuid',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'string'],
                    ],
                ],
            ],
        ];
    }
}
