<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Infrastructure\Shared\Foundry\Provider\CustomImageProvider;
use Ramsey\Uuid\Uuid;

/**
 * @extends AbstractModelFactory<Child>
 *
 * @codeCoverageIgnore
 */
final class ChildFactory extends AbstractModelFactory
{
    public static function class(): string
    {
        return Child::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        $faker = Factory::create();
        $faker->addProvider(new CustomImageProvider($faker));

        $firstname = self::faker()->firstName();
        $lastname = self::faker()->lastName();

        /** @var Generator $uniqueGenerator */
        $uniqueGenerator = self::faker()->unique();

        return [
            'uuid' => Uuid::fromString($uniqueGenerator->uuid()),
            'avatar' => AvatarFactory::createOne(['contentUrl' => $faker->imageUrl($firstname, $lastname)]),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'birthday' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'nurseryStructure' => NurseryStructureFactory::randomOrCreate(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days', 'now')),
            'updatedAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days', 'now')) : null,
            'irp' => self::faker()->boolean() ? IRPFactory::createOne() : null,
            'treatments' => [],
            'customers' => [],
            'contractDates' => [],
        ];
    }
}
