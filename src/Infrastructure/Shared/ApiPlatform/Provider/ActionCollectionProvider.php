<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ActionResource;
use function dump;

/**
 * @extends AbstractCollectionProvider<Action, ActionResource>
 */
class ActionCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        dump($context['filters']['coucou']);

        return [];
    }

    protected function toResource(object $model): object
    {
        return (object) ['foo' => 'bar'];
    }
}
