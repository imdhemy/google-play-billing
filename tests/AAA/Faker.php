<?php

declare(strict_types=1);

namespace Tests\AAA;

use Faker\Generator;

final class Faker extends Generator
{
    public static function create(): self
    {
        return new self();
    }
}
