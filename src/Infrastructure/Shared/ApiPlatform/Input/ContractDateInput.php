<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use Nursery\Infrastructure\Shared\ApiPlatform\Payload\ContractDatePayload;
use Symfony\Component\Serializer\Annotation\Groups;

final class ContractDateInput
{
    /**
     * @param array<int, ContractDatePayload> $contractDates
     */
    public function __construct(
        #[Groups(['contract:item'])]
        /** @var list<ContractDatePayload> $contractDates */
        public array $contractDates,
    ) {
    }
}
