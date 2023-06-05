<?php

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\IntroductoryPriceInfo;
use Tests\TestCase;

class IntroductoryPriceInfoTest extends TestCase
{
    /**
     * @var array
     */
    private $attributes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            IntroductoryPriceInfo::CURRENCY_CODE => $this->faker->currencyCode(),
            IntroductoryPriceInfo::AMOUNT_MICROS => $this->faker->randomElement(range(0, 100)),
            IntroductoryPriceInfo::PRICE_PERIOD => $this->faker->randomElement(
                IntroductoryPriceInfo::INTRO_PRICE_PERIODS
            ),
            IntroductoryPriceInfo::PRICE_CYCLES => $this->faker->randomElement(range(0, 10)),
        ];
    }

    /**
     * @test
     */
    public function construct()
    {
        $introductoryPriceInfo = new IntroductoryPriceInfo(...array_values($this->attributes));
        $this->assertEquals($this->attributes, $introductoryPriceInfo->toArray());
    }

    /**
     * @test
     */
    public function from_array()
    {
        $introductoryPriceInfo = IntroductoryPriceInfo::fromArray($this->attributes);
        $this->assertInstanceOf(IntroductoryPriceInfo::class, $introductoryPriceInfo);
    }
}
