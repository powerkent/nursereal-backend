<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Shared\ApiPlatform\Action\ContractDateDeleteAction;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ContractDateInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ContractDatePostProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ContractDateProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildDatesView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'ContractDate',
    operations: [
        // TODO: Add GetCollection and check Get Item because it's not a right item provider
        new Get(
            normalizationContext: ['groups' => ['contract:item']],
            provider: ContractDateProvider::class,
        ),
        new Post(
            normalizationContext: ['groups' => ['contract:item', 'contract:post:read']],
            denormalizationContext: ['groups' => ['contract:item', 'contract:post:write']],
            security: 'is_granted(\''.Roles::Manager->value.'\')',
            input: ContractDateInput::class,
            processor: ContractDatePostProcessor::class,
        ),
        new Delete(
            controller: ContractDateDeleteAction::class,
            security: 'is_granted(\''.Roles::Manager->value.'\')',
            name: 'delete_contract_dates',
        ),
    ]
)]
final class ContractDateResource
{
    /**
     * @param list<ChildDatesView> $childDates
     */
    public function __construct(
        #[ApiProperty(identifier: false)]
        #[Groups(['contract:item', 'contract:list', 'contract:post:read'])]
        public UuidInterface $childUuid,
        #[Groups(['contract:item', 'contract:list', 'contract:post:read'])]
        public string $firstname,
        #[Groups(['contract:item', 'contract:list', 'contract:post:read'])]
        public string $lastname,
        #[Groups(['contract:item', 'contract:list', 'contract:post:read'])]
        /** @var list<ChildDatesView> $childDates */
        public array $childDates = [],
    ) {
    }
}
