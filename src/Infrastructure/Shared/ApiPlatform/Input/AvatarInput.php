<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use ApiPlatform\Metadata\ApiProperty;
use Nursery\Domain\Shared\Enum\AvatarType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
class AvatarInput
{
    public function __construct(
        #[Groups('avatar:item')]
        public UuidInterface $objectUuid,
        #[Groups('avatar:item')]
        #[ApiProperty(openapiContext: [
            'type' => 'string',
            'enum' => [AvatarType::Agent->value, AvatarType::Customer->value, AvatarType::Child->value],
            'example' => AvatarType::Agent->value,
        ])]
        public AvatarType $type,
        #[Groups('avatar:item')]
        public ?File $file = null,
    ) {
    }
}
