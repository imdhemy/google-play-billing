<?php

declare(strict_types=1);

namespace Tests\AAA;

use Faker\Generator;

/**
 * Aggregates focused fixture providers for the test suite.
 *
 * Keep fixtures in the provider that matches their API area or testing concern;
 * add only broadly shared test primitives directly to this faker.
 *
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

        $faker->addProvider(new GoogleAuthProvider($faker));
        $faker->addProvider(new MonetizationProvider($faker));
        $faker->addProvider(new PurchaseProvider($faker));
        $faker->addProvider(new RtdnProvider($faker));

        return $faker;
    }
}
