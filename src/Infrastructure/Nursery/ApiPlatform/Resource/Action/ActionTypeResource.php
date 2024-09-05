<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Nursery\Domain\Nursery\Enum\SubTypeInterface;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Nursery\ApiPlatform\Provider\ActionTypeCollectionProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'ActionType',
    operations: [
        new GetCollection(
            paginationEnabled: false,
            normalizationContext: ['groups' => ['actionType:list']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
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
