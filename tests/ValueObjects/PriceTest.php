<?php

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\Price;
use Tests\TestCase;

class PriceTest extends TestCase
{
    /**
     * @test
     */
    public function construct_and_getters()
    {
        $currency = $this->faker->currencyCode();
        $micros = $this->faker->randomElement(range(0, 1));

        $price = new Price($micros, $currency);

        $this->assertEquals($currency, $price->getCurrency());
        $this->assertEquals($micros, $price->getPriceMicros());
    }

    /**
     * @test
     */
    public function from_array_to_array()
    {
        $attributes = [
            Price::CURRENCY => $this->faker->currencyCode(),
            Price::PRICE_MICROS => $this->faker->randomElement(range(0, 1)),
        ];

        $price = Price::fromArray($attributes);
        $this->assertInstanceOf(Price::class, $price);

        $this->assertEquals($attributes, $price->toArray());
    }

    /**
     * @test
     */
    public function equals()
    {
        $attributes = [
            Price::CURRENCY => $this->faker->currencyCode(),
            Price::PRICE_MICROS => $this->faker->randomElement(range(0, 1)),
        ];

        $firstPrice = Price::fromArray($attributes);
        $secondPrice = Price::fromArray($attributes);
        $thirdPrice = new Price(0, '');

        $this->assertTrue($firstPrice->equals($secondPrice));
        $this->assertFalse($firstPrice->equals($thirdPrice));
    }
}
