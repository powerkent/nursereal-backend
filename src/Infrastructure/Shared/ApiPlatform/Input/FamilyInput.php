<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use Nursery\Infrastructure\Shared\ApiPlatform\Payload\ChildPayload;
use Nursery\Infrastructure\Shared\ApiPlatform\Payload\CustomerPayload;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class FamilyInput
{
    public function __construct(
        #[Groups(['family:item'])]
        #[Assert\NotBlank(message: 'Family requires a customer.')]
        public CustomerPayload $customerA,
        #[Groups(['family:item'])]
        public ?CustomerPayload $customerB = null,
        #[Groups(['family:item'])]
        public ?bool $isSameAddress = null,
        /** @var list<ChildPayload> $children */
        public array $children = [],
        #[Groups(['family:item'])]
        public ?string $internalComment = null,
    ) {
    }
}
