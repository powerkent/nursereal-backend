<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use Nursery\Infrastructure\Shared\ApiPlatform\Payload\NurseryStructureOpeningPayload;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class NurseryStructureInput
{
    /**
     * @param list<NurseryStructureOpeningPayload> $openings
     */
    public function __construct(
        #[Groups(['nurseryStructure:item'])]
        #[Assert\NotBlank(message: 'Nursery structure requires a name.')]
        public string $name,
        #[Groups(['nurseryStructure:item'])]
        #[Assert\NotBlank(message: 'Nursery structure requires an address.')]
        public string $address,
        #[Groups(['nurseryStructure:item'])]
        public ?string $user,
        #[Groups(['nurseryStructure:item'])]
        public ?string $password,
        #[Groups(['nurseryStructure:item'])]
        /** @var list<NurseryStructureOpeningPayload> $openings */
        public array $openings,
    ) {
    }
}
