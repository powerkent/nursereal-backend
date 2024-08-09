<?php

declare(strict_types=1);

namespace Enum;

enum DiaperQuality: string
{
    case Liquid = 'liquid';
    case Soft = 'soft';
    case Correct = 'correct';
    case Hard = 'hard';
}
