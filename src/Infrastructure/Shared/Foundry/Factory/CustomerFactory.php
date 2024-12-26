<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\Customer;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Customer>
 */
final class CustomerFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Customer::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'uuid' => Uuid::uuid4(),
            'avatar' => AvatarFactory::createOne(),
            'firstname' => self::faker()->firstName(),
            'lastname' => self::faker()->lastName(),
            'email' => self::faker()->email(),
            'user' => self::faker()->name(),
            'password' => self::faker()->password(),
            'phoneNumber' => (int) self::faker()->phoneNumber(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTime()) : null,
        ];
    }
}
