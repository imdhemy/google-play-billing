<?php

declare(strict_types=1);

namespace Tests\AAA;

use Faker\Generator;

/**
 * @mixin DomainProvider
 * @mixin MonetizationProvider
 */
final class Faker extends Generator
{
    public static function create(): self
    {
        $faker = new self();

        $faker->addProvider(new DomainProvider($faker));
        $faker->addProvider(new MonetizationProvider($faker));

        return $faker;
    }
}
