<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\Serializer;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionItemPriceChangeDetails;
use Tests\TestCase;

final class SubscriptionItemPriceChangeDetailsTest extends TestCase
{
    /** @test */
    public function properties(): void
    {
        $data = [
            'newPrice' => [
                'currencyCode' => $this->faker->currencyCode(),
                'units' => (string)$this->faker->randomNumber(5),
                'nanos' => $this->faker->randomNumber(5),
            ],
            'priceChangeMode' => $this->faker->randomElement([
                'PRICE_CHANGE_MODE_UNSPECIFIED',
                'PRICE_DECREASE',
                'PRICE_INCREASE',
                'OPT_OUT_PRICE_INCREASE',
            ]),
            'priceChangeState' => $this->faker->randomElement([
                'PRICE_CHANGE_STATE_UNSPECIFIED',
                'OUTSTANDING',
                'CONFIRMED',
                'APPLIED',
            ]),
            'expectedNewPriceChargeTime' => '2014-10-02T15:01:23.045123456Z',
        ];

        $subscriptionItemPriceChangeDetails = Serializer::create()->deserialize(
            $data,
            SubscriptionItemPriceChangeDetails::class
        );

        $price = Serializer::create()->deserialize($data['newPrice'], Money::class);
        $this->assertEquals($price, $subscriptionItemPriceChangeDetails->newPrice);
        $this->assertEquals($data['priceChangeMode'], $subscriptionItemPriceChangeDetails->priceChangeMode);
        $this->assertEquals($data['priceChangeState'], $subscriptionItemPriceChangeDetails->priceChangeState);
        $this->todo('expectedNewPriceChargeTime');
    }
}
