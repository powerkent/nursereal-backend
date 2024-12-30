<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory;

use DateTimeImmutable;
use Faker\Generator;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Infrastructure\Shared\Foundry\Factory\AbstractModelFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgentFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\ChildFactory;
use Ramsey\Uuid\Uuid;

/**
 * @extends AbstractModelFactory<Action>
 *
 * @codeCoverageIgnore
 */
class ActionFactory extends AbstractModelFactory
{
    public static function class(): string
    {
        return Action::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        /** @var Generator $uniqueGenerator */
        $uniqueGenerator = self::faker()->unique();

        return [
            'uuid' => Uuid::fromString($uniqueGenerator->uuid()),
            'state' => self::faker()->randomElement(ActionState::cases()),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime(self::faker()->dateTimeBetween('-5 days', '+7 days'))),
            'updatedAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days', '+7 days')) : null,
            'child' => ChildFactory::randomOrCreate(),
            'agent' => AgentFactory::randomOrCreate(),
            'comment' => self::faker()->boolean() ? self::faker()->text() : null,
        ];
    }
}
