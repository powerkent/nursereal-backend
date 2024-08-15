<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Nursery\Domain\Shared\Criteria\FilterInterface;
use Nursery\Domain\Shared\Criteria\PaginationFilter;
use Nursery\Infrastructure\Shared\Doctrine\ORM\CastingPaginator;
use function array_map;

/**
 * @template T1 of object
 * @template T2 of object
 * @implements ProviderInterface<T2>
 */
abstract class AbstractCollectionProvider implements ProviderInterface
{
    public function __construct(
        private Pagination $pagination,
    ) {
    }

    /**
     * @param array<string, mixed>  $uriVariables
     * @param list<FilterInterface> $filters
     * @param array<string, mixed>  $context
     *
     * @return iterable<T1>
     */
    abstract public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable;

    /**
     * @phpstan-param T1 $model
     *
     * @phpstan-return T2
     */
    abstract protected function toResource(object $model): object;

    /**
     * @param array<string, mixed> $uriVariables
     * @param array<string, mixed> $context
     *
     * @phpstan-return iterable<T2>
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
        $filters = [];
        if ($this->pagination->isEnabled($operation, $context)) {
            $offset = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation, $context);

            $filters[] = new PaginationFilter($offset - 1, $limit);
        }

        /** @phpstan-var list<T1>|DoctrinePaginator<T1> $models */
        $models = $this->collection($operation, $uriVariables, $filters, $context);

        $castCallable = fn ($m) => $this->toResource($m);

        if ($models instanceof DoctrinePaginator) {
            /** @phpstan-var CastingPaginator<T2> $paginator */
            $paginator = new CastingPaginator($models, $castCallable);

            return new Paginator($paginator);
        }

        return array_map($castCallable, $models);
    }
}
