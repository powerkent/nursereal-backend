<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Faker\Factory;
use Faker\Generator;
use Nursery\Domain\Shared\Model\Avatar;
use Nursery\Infrastructure\Shared\Foundry\Provider\CustomImageProvider;
use Ramsey\Uuid\Uuid;

/**
 * @extends AbstractModelFactory<Avatar>
 *
 * @codeCoverageIgnore
 */
final class AvatarFactory extends AbstractModelFactory
{
    public static function class(): string
    {
        return Avatar::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        $faker = Factory::create();
        $faker->addProvider(new CustomImageProvider($faker));

        /** @var Generator $uniqueGenerator */
        $uniqueGenerator = self::faker()->unique();

        return [
            'uuid' => Uuid::fromString($uniqueGenerator->uuid()),
            'contentUrl' => $faker->imageUrl(),
        ];
    }
}
