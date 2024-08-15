<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Action;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Nursery\Domain\Shared\Enum\SubTypeInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ActionTypeCollectionProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'ActionType',
    operations: [
        new GetCollection(
            paginationEnabled: false,
            normalizationContext: ['groups' => ['actionType:list']],
            provider: ActionTypeCollectionProvider::class,
        ),
    ]
)]
final class ActionTypeResource
{
    /**
     * @param array<string, array<int, mixed>|SubTypeInterface|null> $actionTypes
     */
    public function __construct(
        #[Groups(['actionType:list'])]
        /** @var array<string, array<int, mixed>|SubTypeInterface|null> $actionTypes */
        public array $actionTypes,
    ) {
    }
}
