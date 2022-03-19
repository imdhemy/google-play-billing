<?php

namespace Tests\Subscriptions;

use Carbon\Carbon;
use Imdhemy\GooglePlay\Subscriptions\SubscriptionPurchase;
use Imdhemy\GooglePlay\ValueObjects\Cancellation;
use Imdhemy\GooglePlay\ValueObjects\IntroductoryPriceInfo;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionCancelSurveyResult;
use ReflectionClass;
use ReflectionMethod;
use Tests\TestCase;

class SubscriptionPurchaseTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_be_created_from_array()
    {
        $body = [
            'kind' => 'some_kind',
            'startTimeMillis' => $this->faker->unixTime(),
            'expiryTimeMillis' => $this->faker->unixTime(),
            'autoResumeTimeMillis' => null,
            'autoRenewing' => $this->faker->boolean(),
            'priceCurrencyCode' => $this->faker->currencyCode(),
            'introductoryPriceInfo' => null,
            'countryCode' => $this->faker->countryCode(),
        ];

        $this->assertInstanceOf(SubscriptionPurchase::class, SubscriptionPurchase::fromArray($body));
    }

    /**
     * @test
     */
    public function it_can_get_the_plain_response_body()
    {
        $body = [
            'kind' => 'some_kind',
            'startTimeMillis' => $this->faker->unixTime(),
            'expiryTimeMillis' => $this->faker->unixTime(),
            'autoResumeTimeMillis' => null,
            'autoRenewing' => $this->faker->boolean(),
            'priceCurrencyCode' => $this->faker->currencyCode(),
            'introductoryPriceInfo' => null,
            'countryCode' => $this->faker->countryCode(),
        ];
        $subscriptionPurchase = SubscriptionPurchase::fromArray($body);
        $this->assertSame($body, $subscriptionPurchase->toArray());
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
        $methodObjects = array_diff($publicMethods, $staticMethods);

        $methods = [];

        foreach ($methodObjects as $methodObject) {
            $methods[] = $methodObject->getName();
        }

        $methods = array_diff($methods, ['getPlainResponse', 'toArray']);

        foreach ($methods as $getter) {
            $this->assertNull($productPurchase->$getter(), $getter);
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
            SubscriptionPurchase::PAYMENT_STATE_PENDING,
            SubscriptionPurchase::PAYMENT_STATE_RECEIVED,
            SubscriptionPurchase::PAYMENT_STATE_DEFERRED,
        ]);

        $subscriptionPurchase = SubscriptionPurchase::fromArray(['paymentState' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getPaymentState());
    }

    /**
     * @test
     */
    public function cancel_reason()
    {
        $value = $this->faker->randomElement([
            Cancellation::CANCEL_REASON_BY_USER,
            Cancellation::CANCEL_REASON_BY_SYSTEM,
            Cancellation::CANCEL_REASON_REPLACED,
            Cancellation::CANCEL_REASON_BY_DEVELOPER,
        ]);

        $subscriptionPurchase = SubscriptionPurchase::fromArray(['cancelReason' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getCancellation()->getCancelReason());
    }

    /**
     * @test
     */
    public function user_cancellation_time()
    {
        $value = Carbon::now()->getTimestampMs();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['userCancellationTimeMillis' => $value]);
        $this->assertEquals(
            $value,
            $subscriptionPurchase->getCancellation()->getUserCancellationTime()->getCarbon()->getTimestampMs()
        );
    }

    /**
     * @test
     */
    public function cancel_survey_result()
    {
        $reason = $this->faker->randomElement([
            SubscriptionCancelSurveyResult::CANCEL_SURVEY_REASON_OTHER,
            SubscriptionCancelSurveyResult::CANCEL_SURVEY_REASON_NOT_USING_ENOUGH,
            SubscriptionCancelSurveyResult::CANCEL_SURVEY_REASON_TECHNICAL_ISSUES,
            SubscriptionCancelSurveyResult::CANCEL_SURVEY_REASON_COST_RELATED,
            SubscriptionCancelSurveyResult::CANCEL_SURVEY_REASON_FOUND_BETTER_APP,
        ]);
        $userInput = $this->faker->sentence();

        $value = [
            'cancelSurveyReason' => $reason,
            'userInputCancelReason' => $userInput,
        ];

        $subscriptionPurchase = SubscriptionPurchase::fromArray(['cancelSurveyResult' => $value]);

        $this->assertEquals($value, $subscriptionPurchase->getCancellation()->getCancelSurveyResult()->toArray());
    }

    /**
     * @test
     */
    public function order_id()
    {
        $value = $this->faker->uuid();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['orderId' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getOrderId());
    }

    /**
     * @test
     */
    public function linked_purchase_token()
    {
        $value = $this->faker->uuid();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['linkedPurchaseToken' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getLinkedPurchaseToken());
    }

    /**
     * @test
     */
    public function purchase_type()
    {
        $value = $this->faker->randomElement([
            SubscriptionPurchase::PURCHASE_TYPE_TEST,
            SubscriptionPurchase::PURCHASE_TYPE_PROMO,
        ]);
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['purchaseType' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getPurchaseType());
    }

    /**
     * @test
     */
    public function price_change()
    {
        $value = [
            'newPrice' => [
                'priceMicros' => $this->faker->randomElement(range(0, 100)),
                'currency' => $this->faker->currencyCode(),
            ],
            'state' => 0,
        ];

        $subscriptionPurchase = SubscriptionPurchase::fromArray(['priceChange' => $value]);

        $this->assertEquals($value, $subscriptionPurchase->getPriceChange()->toArray());
    }

    /**
     * @test
     */
    public function profile_name()
    {
        $value = $this->faker->name();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['profileName' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getProfileName());
    }

    /**
     * @test
     */
    public function email_address()
    {
        $value = $this->faker->email();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['emailAddress' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getEmailAddress());
    }

    /**
     * @test
     */
    public function given_name()
    {
        $value = $this->faker->name();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['givenName' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getGivenName());
    }

    /**
     * @test
     */
    public function family_name()
    {
        $value = $this->faker->name();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['familyName' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getFamilyName());
    }

    /**
     * @test
     */
    public function profile_id()
    {
        $value = $this->faker->uuid();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['profileId' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getProfileId());
    }

    /**
     * @test
     */
    public function acknowledgement_state()
    {
        $value = $this->faker->randomElement([
            SubscriptionPurchase::ACKNOWLEDGEMENT_STATE_NOT_ACKNOWLEDGED,
            SubscriptionPurchase::ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED,
        ]);

        $subscriptionPurchase = SubscriptionPurchase::fromArray(['acknowledgementState' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getAcknowledgementState());
    }

    /**
     * @test
     */
    public function external_account_id()
    {
        $value = $this->faker->uuid();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['externalAccountId' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getExternalAccountId());
    }

    /**
     * @test
     */
    public function promotion_type()
    {
        $value = $this->faker->randomElement([
            SubscriptionPurchase::PROMOTION_TYPE_ONE_TIME_CODE,
            SubscriptionPurchase::PROMOTION_TYPE_VANITY_CODE,
        ]);
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['promotionType' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getPromotionType());
    }

    /**
     * @test
     */
    public function promotion_code()
    {
        $value = $this->faker->uuid();
        $subscriptionPurchase = SubscriptionPurchase::fromArray([
            'promotionType' => 1,
            'promotionCode' => $value,
        ]);
        $this->assertEquals($value, $subscriptionPurchase->getPromotionCode());
    }

    /**
     * @test
     */
    public function obfuscated_external_account_id()
    {
        $value = $this->faker->uuid();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['obfuscatedExternalAccountId' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getObfuscatedExternalAccountId());
    }

    /**
     * @test
     */
    public function obfuscated_external_profile_id()
    {
        $value = $this->faker->uuid();
        $subscriptionPurchase = SubscriptionPurchase::fromArray(['obfuscatedExternalProfileId' => $value]);
        $this->assertEquals($value, $subscriptionPurchase->getObfuscatedExternalProfileId());
    }
}
