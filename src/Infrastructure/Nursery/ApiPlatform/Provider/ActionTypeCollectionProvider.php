<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action\ActionTypeResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action\ActionTypeResourceFactory;

/**
 * @extends AbstractCollectionProvider<ActionType, ActionTypeResource>
 */
class ActionTypeCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private ActionTypeResourceFactory $actionTypeResourceFactory,
        Pagination $pagination
    ) {
        parent::__construct($pagination);
    }

    /**
     * @param array<string, mixed> $uriVariables
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        $actionTypes = [];
        foreach (ActionType::values() as $value) {
            $actionTypes[$value] = ActionType::from($value);
        }

        return $actionTypes;
    }

    /**
     * @param ActionType $model
     *
     * @return ActionTypeResource
     */
    protected function toResource($model): object
    {
        return $this->actionTypeResourceFactory->fromModel($model);
    }
}
