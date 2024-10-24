<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Provider;

use Faker\Generator;
use Faker\Provider\Base;

class CustomImageProvider extends Base
{
    private const BACKGROUND_COLORS = [
        '0D8ABC',
        'A23E48',
        'F2B43F',
        '45A29E',
        'C3073F',
        'F7B32B',
        '379683',
        '5CDB95',
        '05386B',
        '3282B8',
        'E17055',
        'F39C12',
        '27AE60',
        '2980B9',
        '8E44AD',
        'E74C3C',
        'F1C40F',
        '2ECC71',
    ];

    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
    }

    public function imageUrl(string $firstname = 'John', string $lastname = 'Doe'): string
    {
        $background = self::BACKGROUND_COLORS[self::numberBetween(0, count(self::BACKGROUND_COLORS) - 1)];

        return "https://ui-avatars.com/api/?name={$firstname}+{$lastname}&background={$background}";
    }
}
