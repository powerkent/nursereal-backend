<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

use ApiPlatform\OpenApi\Model\RequestBody;
use ArrayObject;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;

/**
 * @codeCoverageIgnore
 */
final readonly class ContractDateResourceOpenApiContext implements OpenApiContextInterface
{
    public function __construct(private ChildRepositoryInterface $childRepository)
    {
    }

    public function operations(): array
    {
        $children = $this->childRepository->all();
        $childrenValues = [];
        foreach ($children as $child) {
            $childrenValues[] = sprintf('%d: %s %s', $child->getId(), $child->getFirstname(), $child->getLastname());
        }

        return [
            'GET /api/contract_dates' => [
                'parameters' => [
                    [
                        'name' => 'child',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => $childrenValues]],
                    ],
                ],
            ],
            'POST /api/contract_dates' => [
                'parameters' => [
                    [
                        'name' => 'child',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => $childrenValues]],
                    ],
                ],
            ],
            'DELETE /api/contract_dates' => [
                'operation_id' => 'delete_contract_dates',
                'summary' => 'Delete contract date for a child',
                'description' => 'Delete contract date for a child',
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
