<?php

namespace Imdhemy\GooglePlay\Tests\Subscriptions;

use Carbon\Carbon;
use Faker\Factory;
use Imdhemy\GooglePlay\Subscriptions\SubscriptionPurchase;
use Imdhemy\GooglePlay\Tests\TestCase;
use Imdhemy\GooglePlay\ValueObjects\IntroductoryPriceInfo;
use Imdhemy\GooglePlay\ValueObjects\PaymentState;
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

    /**
     * @test
     */
    public function test_start_time()
    {
        $value = Carbon::now()->getTimestampMs();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['startTimeMillis' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getStartTime()->getCarbon()->getTimestampMs());
    }

    /**
     * @test
     */
    public function expiry_time()
    {
        $value = Carbon::now()->getTimestampMs();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['expiryTimeMillis' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getExpiryTime()->getCarbon()->getTimestampMs());
    }

    /**
     * @test
     */
    public function auto_resume_time()
    {
        $value = Carbon::now()->getTimestampMs();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['autoResumeTimeMillis' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getAutoResumeTime()->getCarbon()->getTimestampMs());
    }

    /**
     * @test
     */
    public function auto_renewing()
    {
        $value = $this->faker->boolean();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['autoRenewing' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->isAutoRenewing());
    }

    /**
     * @test
     */
    public function price_currency_code()
    {
        $value = $this->faker->currencyCode();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['priceCurrencyCode' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getPriceCurrencyCode());
    }

    /**
     * @test
     */
    public function price_amount_micros()
    {
        $value = $this->faker->randomElement(range(0, 100));
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['priceAmountMicros' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getPriceAmountMicros());
    }

    /**
     * @test
     */
    public function introductory_price_info()
    {
        $value = [
            'introductoryPriceCurrencyCode' => $this->faker->currencyCode(),
            'introductoryPriceAmountMicros' => $this->faker->randomElement(range(0, 100)),
            'introductoryPricePeriod' => $this->faker->randomElement(IntroductoryPriceInfo::INTRO_PRICE_PERIODS),
            'introductoryPriceCycles' => $this->faker->randomElement(range(0, 10)),
        ];

        $subscriptionPurchase = SubscriptionPurchase::fromArray(['introductoryPriceInfo' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getIntroductoryPriceInfo()->toArray());
    }

    /**
     * @test
     */
    public function country_code()
    {
        $value = $this->faker->countryCode();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['countryCode' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getCountryCode());
    }

    /**
     * @test
     */
    public function developer_payload()
    {
        $value = json_encode(['uuid' => $this->faker->uuid()]);
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['developerPayload' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getDeveloperPayload());
    }

    /**
     * @test
     */
    public function payment_state()
    {
        $value = $this->faker->randomElement([
            PaymentState::PAYMENT_STATE_PENDING,
            PaymentState::PAYMENT_STATE_RECEIVED,
            PaymentState::PAYMENT_STATE_DEFERRED,
        ]);

        $subscriptionPurchase = SubscriptionPurchase::fromArray(['paymentState' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getPaymentState()->getValue());
    }
}
