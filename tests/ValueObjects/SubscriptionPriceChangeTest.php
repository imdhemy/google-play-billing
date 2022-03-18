<?php

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\Price;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionPriceChange;
use Tests\TestCase;

class SubscriptionPriceChangeTest extends TestCase
{
    /**
     * @var Price
     */
    private $price;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->price = new Price($this->faker->randomElement(range(1, 100)), $this->faker->currencyCode());
    }

    /**
     * @test
     */
    public function get_new_price()
    {
        $subscriptionPriceChange = new SubscriptionPriceChange(
            $this->price,
            SubscriptionPriceChange::STATE_OUTSTANDING
        );

        $this->assertSame($this->price, $subscriptionPriceChange->getNewPrice());
    }

    /**
     * @test
     */
    public function get_state()
    {
        $state = SubscriptionPriceChange::STATE_OUTSTANDING;

        $subscriptionPriceChange = new SubscriptionPriceChange(
            $this->price,
            $state
        );

        $this->assertSame($state, $subscriptionPriceChange->getState());
        $this->assertTrue($subscriptionPriceChange->isOutstanding());
        $this->assertFalse($subscriptionPriceChange->isAccepted());

        $state = SubscriptionPriceChange::STATE_ACCEPTED;
        $subscriptionPriceChange = new SubscriptionPriceChange(
            $this->price,
            $state
        );
        $this->assertFalse($subscriptionPriceChange->isOutstanding());
        $this->assertTrue($subscriptionPriceChange->isAccepted());
    }

    /**
     * @test
     */
    public function to_array()
    {
        $state = SubscriptionPriceChange::STATE_OUTSTANDING;

        $subscriptionPriceChange = new SubscriptionPriceChange(
            $this->price,
            $state
        );

        $expected = [
            SubscriptionPriceChange::ATTR_NEW_PRICE => $this->price->toArray(),
            SubscriptionPriceChange::ATTR_STATE => $state,
        ];

        $this->assertEquals($expected, $subscriptionPriceChange->toArray());
    }
}
