<?php

declare(strict_types=1);

namespace Enum;

enum CareType: string
{
    case Diaper = 'diaper';
    case EyeCare = 'eye_care';
    case NoseCare = 'nose_care';
    case EarCare = 'ear_care';
    case Other = 'other';
}
