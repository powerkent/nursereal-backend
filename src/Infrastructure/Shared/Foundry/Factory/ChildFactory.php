<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Nursery\Domain\Shared\Model\Child;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Child>
 */
final class ChildFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Child::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'uuid' => Uuid::uuid4(),
            'avatar' => AvatarFactory::createOne(),
            'firstname' => self::faker()->firstName(),
            'lastname' => self::faker()->lastName(),
            'birthday' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => self::faker()->boolean() ? \DateTimeImmutable::createFromMutable(self::faker()->dateTime()) : null,
            'nurseryStructure' => NurseryStructureFactory::random(),
        ];
    }
}
