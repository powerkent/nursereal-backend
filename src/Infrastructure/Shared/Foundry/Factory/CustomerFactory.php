<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Faker\Generator;
use Nursery\Domain\Shared\Model\Customer;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends @extends PersistentProxyObjectFactory<Customer>
 *
 * @codeCoverageIgnore
 */
final class CustomerFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Customer::class;
    }

    protected function defaults(): array|callable
    {
        /** @var Generator $uniqueGenerator */
        $uniqueGenerator = self::faker()->unique();

        return [
            'uuid' => Uuid::fromString($uniqueGenerator->uuid()),
            'avatar' => self::faker()->boolean() ? AvatarFactory::createOne() : null,
            'firstname' => self::faker()->firstName(),
            'lastname' => self::faker()->lastName(),
            'email' => self::faker()->email(),
            'user' => self::faker()->name(),
            'password' => self::faker()->password(),
            'phoneNumber' => (int) self::faker()->phoneNumber(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days')),
            'updatedAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days')) : null,
            'children' => [],
            'roles' => [],
        ];
    }
}
