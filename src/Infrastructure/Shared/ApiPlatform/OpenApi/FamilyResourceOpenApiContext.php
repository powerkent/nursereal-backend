<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Repository\NurseryStructureRepositoryInterface;

/**
 * @codeCoverageIgnore
 */
final readonly class FamilyResourceOpenApiContext implements OpenApiContextInterface
{
    public function __construct(private NurseryStructureRepositoryInterface $nurseryStructureRepository)
    {
    }

    public function operations(): array
    {
        $nurseries = $this->nurseryStructureRepository->all();
        $nurseriesValues = array_map(fn (NurseryStructure $ns) => $ns->getUuid()->toString(), $nurseries);

        return [
            'GET /api/families' => [
                'parameters' => [
                    [
                        'name' => 'nursery_structures[]',
                        'in' => 'query',
                        'explode' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => $nurseriesValues]],
                    ],
                ],
            ],
        ];
    }
}
