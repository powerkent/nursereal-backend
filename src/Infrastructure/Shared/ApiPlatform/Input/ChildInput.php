<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use ApiPlatform\Metadata\ApiProperty;
use Nursery\Domain\Shared\Processor\ChildInputDataInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Payload\IRPPayload;
use Nursery\Infrastructure\Shared\ApiPlatform\Payload\TreatmentPayload;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class ChildInput implements ChildInputDataInterface
{
    /**
     * @param list<TreatmentPayload> $treatments
     */
    public function __construct(
        #[Groups(['child:item'])]
        public ?string $avatar,
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
        #[Assert\NotBlank(message: 'Child requires a nursery structure.')]
        public UuidInterface $nurseryStructureUuid,
        #[Groups(['child:item'])]
        public ?IRPPayload $irp = null,
        #[Groups(['child:item'])]
        /** @var list<TreatmentPayload> $treatments */
        public ?array $treatments = [],
    ) {
    }
}
