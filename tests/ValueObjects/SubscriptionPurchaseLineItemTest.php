<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\AutoRenewingPlan;
use Imdhemy\GooglePlay\ValueObjects\DeferredItemReplacement;
use Imdhemy\GooglePlay\ValueObjects\InstallmentPlan;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Imdhemy\GooglePlay\ValueObjects\OfferDetails;
use Imdhemy\GooglePlay\ValueObjects\PrepaidPlan;
use Imdhemy\GooglePlay\ValueObjects\SignupPromotion;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionItemPriceChangeDetails;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionPurchaseLineItem;
use Imdhemy\GooglePlay\ValueObjects\Time;
use Tests\TestCase;

final class SubscriptionPurchaseLineItemTest extends TestCase
{
    /** @test */
    public function instantiate_with_auto_renewing_plan(): void
    {
        $data = [
            'productId' => $this->faker->word(),
            'expiryTime' => '2014-10-02T15:01:23Z',
            'latestSuccessfulOrderId' => $this->faker->uuid(),
            'autoRenewingPlan' => [
                'autoRenewEnabled' => true,
                'recurringPrice' => [
                    'currencyCode' => $this->faker->currencyCode(),
                    'units' => (string)$this->faker->randomNumber(5),
                    'nanos' => $this->faker->randomNumber(5),
                ],
                'priceChangeDetails' => [
                    'newPrice' => [
                        'currencyCode' => $this->faker->currencyCode(),
                        'units' => (string)$this->faker->randomNumber(5),
                        'nanos' => $this->faker->randomNumber(5),
                    ],
                    'priceChangeMode' => 'PRICE_INCREASE',
                    'priceChangeState' => 'OUTSTANDING',
                    'expectedNewPriceChargeTime' => '2014-10-02T15:01:23.045123456Z',
                ],
                'installmentDetails' => [
                    'initialCommittedPaymentsCount' => 3,
                    'subsequentCommittedPaymentsCount' => 2,
                    'remainingCommittedPaymentsCount' => 1,
                    'pendingCancellation' => [],
                ],
            ],
            'offerDetails' => [
                'offerTags' => [$this->faker->word()],
                'basePlanId' => $this->faker->word(),
                'offerId' => $this->faker->word(),
            ],
            'signupPromotion' => [
                'oneTimeCode' => [],
            ],
        ];

        $actual = $this->normalizer->normalize($data, SubscriptionPurchaseLineItem::class);

        $this->assertInstanceOf(SubscriptionPurchaseLineItem::class, $actual);
        $this->assertSame($data['productId'], $actual->productId);
        $this->assertInstanceOf(Time::class, $actual->expiryTime);
        $this->assertSame($data['latestSuccessfulOrderId'], $actual->latestSuccessfulOrderId);
        $this->assertInstanceOf(AutoRenewingPlan::class, $actual->autoRenewingPlan);
        $this->assertNull($actual->prepaidPlan);
        $this->assertInstanceOf(OfferDetails::class, $actual->offerDetails);
        $this->assertNull($actual->deferredItemReplacement);
        $this->assertInstanceOf(SignupPromotion::class, $actual->signupPromotion);
        $this->assertInstanceOf(Money::class, $actual->autoRenewingPlan->recurringPrice);
        $this->assertInstanceOf(
            SubscriptionItemPriceChangeDetails::class,
            $actual->autoRenewingPlan->priceChangeDetails
        );
        $this->assertInstanceOf(InstallmentPlan::class, $actual->autoRenewingPlan->installmentDetails);
    }

    /** @test */
    public function instantiate_with_prepaid_plan_and_deferred_item_replacement(): void
    {
        $data = [
            'productId' => $this->faker->word(),
            'expiryTime' => '2014-10-02T15:01:23Z',
            'latestSuccessfulOrderId' => $this->faker->uuid(),
            'prepaidPlan' => [
                'allowExtendAfterTime' => '2014-10-02T15:01:23Z',
            ],
            'offerDetails' => [
                'offerTags' => [$this->faker->word()],
                'basePlanId' => $this->faker->word(),
                'offerId' => $this->faker->word(),
            ],
            'deferredItemReplacement' => [
                'productId' => $this->faker->word(),
            ],
        ];

        $actual = $this->normalizer->normalize($data, SubscriptionPurchaseLineItem::class);

        $this->assertInstanceOf(SubscriptionPurchaseLineItem::class, $actual);
        $this->assertSame($data['productId'], $actual->productId);
        $this->assertInstanceOf(Time::class, $actual->expiryTime);
        $this->assertSame($data['latestSuccessfulOrderId'], $actual->latestSuccessfulOrderId);
        $this->assertNull($actual->autoRenewingPlan);
        $this->assertInstanceOf(PrepaidPlan::class, $actual->prepaidPlan);
        $this->assertInstanceOf(Time::class, $actual->prepaidPlan->allowExtendAfterTime);
        $this->assertInstanceOf(OfferDetails::class, $actual->offerDetails);
        $this->assertInstanceOf(DeferredItemReplacement::class, $actual->deferredItemReplacement);
        $this->assertNull($actual->signupPromotion);
    }
}
