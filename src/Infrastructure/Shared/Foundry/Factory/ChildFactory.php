<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Faker\Factory;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Infrastructure\Shared\Foundry\Provider\CustomImageProvider;
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
        $faker = Factory::create();
        $faker->addProvider(new CustomImageProvider($faker));

        $firstname = self::faker()->firstName();
        $lastname = self::faker()->lastName();

        return [
            'uuid' => Uuid::uuid4(),
            'avatar' => AvatarFactory::createOne(['contentUrl' => $faker->imageUrl($firstname, $lastname)]),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'birthday' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => self::faker()->boolean() ? \DateTimeImmutable::createFromMutable(self::faker()->dateTime()) : null,
            'nurseryStructure' => NurseryStructureFactory::random(),
        ];
    }
}
