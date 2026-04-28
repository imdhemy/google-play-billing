<?php

declare(strict_types=1);

namespace Tests\AAA;

use Faker\Generator;

/**
 * @mixin GoogleAuthProvider
 * @mixin MonetizationProvider
 * @mixin PurchaseProvider
 * @mixin RtdnProvider
 */
final class Faker extends Generator
{
    public static function create(): self
    {
        $faker = new self();

        $faker->addProvider(new GoogleAuthProvider());
        $faker->addProvider(new MonetizationProvider());
        $faker->addProvider(new PurchaseProvider($faker));
        $faker->addProvider(new RtdnProvider());

        return $faker;
    }
}
