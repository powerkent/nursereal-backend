<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Input;

use ApiPlatform\Metadata\ApiProperty;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\IRPPayload;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\TreatmentPayload;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class ChildInput
{
    /**
     * @param list<TreatmentPayload> $treatments
     */
    public function __construct(
        #[Groups(['child:item'])]
        #[Assert\NotBlank(message: 'Child requires a firstname.')]
        public string $firstname,
        #[Groups(['child:item'])]
        #[Assert\NotBlank(message: 'Child requires a lastname.')]
        public string $lastname,
        #[Groups(['child:item'])]
        #[Assert\NotBlank(message: 'Child requires a birthday')]
        #[ApiProperty(openapiContext: ['example' => '2024-01-01 00:00:00'])]
        public string $birthday,
        #[Groups(['child:item'])]
        public ?IRPPayload $irp = null,
        #[Groups(['child:item'])]
        /** @var list<TreatmentPayload> $treatments */
        public ?array $treatments = [],
    ) {
    }
}
