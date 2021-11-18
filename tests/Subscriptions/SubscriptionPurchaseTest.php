<?php

namespace Imdhemy\GooglePlay\Tests\Subscriptions;

use Faker\Factory;
use Imdhemy\GooglePlay\Subscriptions\SubscriptionPurchase;
use Imdhemy\GooglePlay\Tests\TestCase;
use ReflectionClass;
use ReflectionMethod;

class SubscriptionPurchaseTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_be_created_from_array()
    {
        $faker = Factory::create();
        $body = [
            'kind' => 'some_kind',
            'startTimeMillis' => $faker->unixTime,
            'expiryTimeMillis' => $faker->unixTime,
            'autoResumeTimeMillis' => null,
            'autoRenewing' => $faker->boolean,
            'priceCurrencyCode' => $faker->currencyCode,
            'introductoryPriceInfo' => null,
            'countryCode' => $faker->countryCode,
        ];

        $this->assertInstanceOf(SubscriptionPurchase::class, SubscriptionPurchase::fromArray($body));
    }

    /**
     * @test
     */
    public function test_all_props_are_optional()
    {
        $productPurchase = SubscriptionPurchase::fromArray([]);
        $this->assertInstanceOf(SubscriptionPurchase::class, $productPurchase);

        $reflectionClass = new ReflectionClass($productPurchase);
        $publicMethods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
        $staticMethods = $reflectionClass->getMethods(ReflectionMethod::IS_STATIC);
        $methods = array_diff($publicMethods, $staticMethods);

        foreach ($methods as $method) {
            $getter = $method->getName();
            $this->assertNull($productPurchase->$getter());
        }
    }

    /**
     * @test
     */
    public function test_kind()
    {
        $value = $this->faker->word();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['kind' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getKind());
    }
}
