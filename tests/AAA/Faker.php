<?php

declare(strict_types=1);

namespace Tests\AAA;

use Faker\Generator;

/**
 * @mixin DomainProvider
 */
final class Faker extends Generator
{
    public static function create(): self
    {
        $faker = new self();

        $faker->addProvider(new DomainProvider($faker));

        return $faker;
    }
}
