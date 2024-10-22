<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Provider;

use Faker\Generator;
use Faker\Provider\Base;

class CustomImageProvider extends Base
{
    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
    }

    public function imageUrl(int $width = 640, int $height = 480): string
    {
        return "https://via.placeholder.com/{$width}x{$height}";
    }
}
