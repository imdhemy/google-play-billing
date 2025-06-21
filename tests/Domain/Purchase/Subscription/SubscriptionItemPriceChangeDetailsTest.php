<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscriptionItemPriceChangeDetails as Sut;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Imdhemy\GooglePlay\ValueObjects\Time;
use Tests\TestCase;

final class SubscriptionItemPriceChangeDetailsTest extends TestCase
{
    /** @test */
    public function instantiate(): void
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

        $actual = $this->normalizer->normalize($data, Sut::class);

        $price = $this->normalizer->normalize($data['newPrice'], Money::class);
        $this->assertEquals($price, $actual->newPrice);
        $this->assertEquals($data['priceChangeMode'], $actual->priceChangeMode);
        $this->assertEquals($data['priceChangeState'], $actual->priceChangeState);
        $this->assertEquals(new Time($data['expectedNewPriceChargeTime']), $actual->expectedNewPriceChargeTime);
    }

    /** @test */
    public function instantiate_without_optional_fields(): void
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
        ];

        $actual = $this->normalizer->normalize($data, Sut::class);

        $this->assertNull($actual->expectedNewPriceChargeTime);
    }
}
