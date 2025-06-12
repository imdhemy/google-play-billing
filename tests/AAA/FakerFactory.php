<?php

declare(strict_types=1);

namespace Tests\AAA;

use Faker\Factory;

final class FakerFactory extends Factory
{
    public static function create($locale = self::DEFAULT_LOCALE): Faker
    {
        $generator = new Faker();

        foreach (parent::$defaultProviders as $provider) {
            $providerClassName = self::getProviderClassname($provider, $locale);
            $generator->addProvider(new $providerClassName($generator));
        }

        return $generator;
    }
}
