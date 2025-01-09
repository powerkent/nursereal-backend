<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use ApiPlatform\Metadata\ApiProperty;
use Nursery\Domain\Shared\Processor\ShiftTypeInputInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Payload\NurseryStructurePayload;
use Symfony\Component\Serializer\Annotation\Groups;

final class ShiftTypeInput implements ShiftTypeInputInterface
{
    /**
     * @param array<int, NurseryStructurePayload> $nurseryStructures
     */
    public function __construct(
        #[Groups(['shiftType:item'])]
        public string $name,
        #[Groups(['shiftType:item'])]
        #[ApiProperty(openapiContext: ['example' => '07:00'])]
        public string $arrivalTime,
        #[Groups(['shiftType:item'])]
        #[ApiProperty(openapiContext: ['example' => '15:00'])]
        public string $endOfWorkTime,
        #[Groups(['shiftType:item'])]
        #[ApiProperty(openapiContext: ['example' => '12:00'])]
        public string $breakTime,
        #[Groups(['shiftType:item'])]
        #[ApiProperty(openapiContext: ['example' => '13:00'])]
        public string $endOfBreakTime,
        #[Groups(['shiftType:item'])]
        /** @var list<NurseryStructurePayload> $nurseryStructures */
        public array $nurseryStructures,
    ) {
    }
}
