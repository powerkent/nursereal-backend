<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Enum;

enum DiaperQuality: string
{
    case Liquid = 'liquid';
    case Soft = 'soft';
    case Correct = 'correct';
    case Hard = 'hard';
}
