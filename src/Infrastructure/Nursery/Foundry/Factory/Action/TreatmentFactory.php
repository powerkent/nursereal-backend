<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Model\Action\Treatment;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\TreatmentFactory as WhatTreatmentFactory;

/**
 * @codeCoverageIgnore
 */
final class TreatmentFactory extends ActionFactory
{
    protected function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'treatment' => WhatTreatmentFactory::randomOrCreate(),
            'dose' => self::faker()->boolean() ? self::faker()->words(3, true) : null,
            'dosingTime' => self::faker()->boolean() ? self::faker()->dateTime() : null,
            'temperature' => self::faker()->boolean() ? self::faker()->randomFloat(35, 39) : null,
        ]);
    }

    public static function class(): string
    {
        return Treatment::class;
    }
}
