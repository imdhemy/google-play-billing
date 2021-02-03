<?php

namespace Imdhemy\GooglePlay\Tests\Subscriptions;

use Faker\Factory;
use GuzzleHttp\Exception\GuzzleException;
use Imdhemy\GooglePlay\ClientFactory;
use Imdhemy\GooglePlay\Subscriptions\Subscription;
use Imdhemy\GooglePlay\Subscriptions\SubscriptionPurchase;
use Imdhemy\GooglePlay\Tests\TestCase;
use Imdhemy\GooglePlay\ValueObjects\Cancellation;
use Imdhemy\GooglePlay\ValueObjects\IntroductoryPriceInfo;
use Imdhemy\GooglePlay\ValueObjects\PromotionType;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionPriceChange;

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

    /**
     * @test
     */
    public function test_it_can_get_IntroductoryPriceInfo()
    {
        $faker = Factory::create();
        $body = [
            'kind' => 'some_kind',
            'introductoryPriceInfo' => [
                'introductoryPriceCurrencyCode' => $faker->currencyCode,
                'introductoryPriceAmountMicros' => $faker->numberBetween(),
                'introductoryPricePeriod' => $faker->randomElement(['P1W', 'P1M', 'P3M', 'P6M', 'P1Y']),
                'introductoryPriceCycles' => $faker->numberBetween(),
            ],
        ];
        $introductoryPriceInfo = SubscriptionPurchase::fromResponseBody($body)->getIntroductoryPriceInfo();
        $this->assertInstanceOf(IntroductoryPriceInfo::class, $introductoryPriceInfo);
    }

    /**
     * @test
     */
    public function test_it_can_get_PriceChange()
    {
        $faker = Factory::create();
        $body = [
            'kind' => 'some_kind',
            'priceChange' => [
                'newPrice' => [
                    'priceMicros' => $faker->numberBetween(),
                    'currency' => $faker->currencyCode,
                ],
                'state' => $faker->randomElement([0, 1]),
            ],
        ];

        $priceChange = SubscriptionPurchase::fromResponseBody($body)->getPriceChange();
        $this->assertInstanceOf(SubscriptionPriceChange::class, $priceChange);
    }

    /**
     * @test
     */
    public function test_it_can_get_cancellation()
    {
        $faker = Factory::create();
        $body = [
            'kind' => 'some_kind',
            'cancelReason' => $faker->randomElement([0, 1, 2, 3]),
            'userCancellationTimeMillis' => $faker->unixTime,
            'cancelSurveyResult' => [
                'cancelSurveyReason' => $faker->randomElement(range(0, 4)),
                'userInputCancelReason' => $faker->sentence,
            ],
        ];

        $cancellation = SubscriptionPurchase::fromResponseBody($body)->getCancellation();
        $this->assertInstanceOf(Cancellation::class, $cancellation);
    }

    /**
     * @test
     */
    public function test_it_can_get_promotion()
    {
        $faker = Factory::create();
        $body = [
            'kind' => 'some_kind',
            'promotionType' => rand(0, 1),
            'promotionCode' => $faker->word(),
        ];

        $promotion = SubscriptionPurchase::fromResponseBody($body)->getPromotionType();
        $this->assertInstanceOf(PromotionType::class, $promotion);
    }

    /**
     * @test
     */
    public function test_time_values_may_be_missed()
    {
        $purchase = SubscriptionPurchase::fromResponseBody([]);

        $this->assertNull($purchase->getStartTime());
        $this->assertNull($purchase->getExpiryTime());
        $this->assertNull($purchase->getAutoResumeTime());
        $this->assertNull($purchase->getCancellation()->getUserCancellationTime());
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function test_it_can_get_null_linked_purchaseToken()
    {
        $client = ClientFactory::create([ClientFactory::SCOPE_ANDROID_PUBLISHER]);
        $packageName = 'com.twigano.fashion';
        $subscriptionId = 'week_premium';
        $token = 'fbfkmfikhhhgienojccgafoe.AO-J1OzzBrmgttPXhWuMXb6B371gmcDsrSVAZCvb9OGzd8PESkDNL-i3aOqpfHKVHUgtcbbfS53WH8KKAXncmPy5qHP_h3A8rQ';

        $purchase = (new Subscription($client, $packageName, $subscriptionId, $token))->get();
        $linkedPurchaseToken = $purchase->getLinkedPurchaseToken();
        $this->assertNull($linkedPurchaseToken);
    }
}
