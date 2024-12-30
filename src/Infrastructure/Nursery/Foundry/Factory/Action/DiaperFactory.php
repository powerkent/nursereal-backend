<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Enum\DiaperQuality;
use Nursery\Domain\Nursery\Model\Action\Diaper;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;

/**
 * @codeCoverageIgnore
 */
final class DiaperFactory extends ActionFactory
{
    protected function defaults(): array
    {
        return array_merge(parent::defaults(), ['quality' => self::faker()->randomElement(DiaperQuality::cases())]);
    }

    public static function class(): string
    {
        return Diaper::class;
    }
}
