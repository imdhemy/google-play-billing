<?php

namespace Imdhemy\GooglePlay\Tests\Subscriptions;

use Faker\Factory;
use Imdhemy\GooglePlay\Subscriptions\SubscriptionPurchase;
use Imdhemy\GooglePlay\Tests\TestCase;

class SubscriptionPurchaseTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_be_created_from_response_body()
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

        $this->assertInstanceOf(SubscriptionPurchase::class, SubscriptionPurchase::fromResponseBody($body));
    }
}
