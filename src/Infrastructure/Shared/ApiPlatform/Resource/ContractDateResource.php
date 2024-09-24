<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Shared\ApiPlatform\Action\ContractDateDeleteAction;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ContractDateInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ContractDatePostProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ContractDateCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildDatesView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'ContractDate',
    operations: [
        new GetCollection(
            paginationEnabled: false,
            normalizationContext: ['groups' => ['contract:list']],
            provider: ContractDateCollectionProvider::class,
        ),
        new Post(
            normalizationContext: ['groups' => ['contract:item', 'contract:post:read']],
            denormalizationContext: ['groups' => ['contract:item', 'contract:post:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: ContractDateInput::class,
            processor: ContractDatePostProcessor::class,
        ),
        new Delete(
            controller: ContractDateDeleteAction::class,
            security: "is_granted('".Roles::Manager->value."')",
        ),
    ]
)]
final class ContractDateResource
{
    /**
     * @param list<ChildDatesView> $childDates
     */
    public function __construct(
        #[Groups(['contract:item', 'contract:list'])]
        public UuidInterface $childUuid,
        #[Groups(['contract:item', 'contract:list'])]
        public string $firstname,
        #[Groups(['contract:item', 'contract:list'])]
        public string $lastname,
        #[Groups(['contract:item', 'contract:list'])]
        /** @var list<ChildDatesView> $childDates */
        public array $childDates = [],
    ) {
    }
}
