<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Enum\CareType;
use Nursery\Domain\Nursery\Model\Action\Care;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;

/**
 * @codeCoverageIgnore
 */
final class CareFactory extends ActionFactory
{
    public function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'types' => self::faker()->randomElements(CareType::cases()),
        ]);
    }

    public static function class(): string
    {
        return Care::class;
    }
}
