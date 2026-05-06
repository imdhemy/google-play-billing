<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscriptionPurchaseLineItem;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SubscriptionPurchaseLineItemTest extends TestCase
{
    #[Test]
    public function instantiation_with_all_props(): void
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
            'prepaidPlan' => [
                'allowExtendAfterTime' => '2014-10-02T15:01:23Z',
            ],
            'deferredItemReplacement' => [
                'productId' => $this->faker->word(),
            ],
            'signupPromotion' => [
                'oneTimeCode' => [],
            ],
            'offerPhase' => [
                'freeTrial' => [],
            ],
        ];

        $actual = $this->normalizer->normalize($data, SubscriptionPurchaseLineItem::class);

        $this->assertSame($data['productId'], $actual->productId);
        $this->assertSame($data['expiryTime'], $actual->expiryTime->originalValue);
        $this->assertSame($data['latestSuccessfulOrderId'], $actual->latestSuccessfulOrderId);
        $this->assertNotNull($actual->autoRenewingPlan);
        $this->assertNotNull($actual->prepaidPlan);
        $this->assertSame(
            $data['prepaidPlan']['allowExtendAfterTime'],
            $actual->prepaidPlan->allowExtendAfterTime->originalValue
        );
        $this->assertSame($data['offerDetails']['offerTags'], $actual->offerDetails->offerTags);
        $this->assertSame($data['offerDetails']['basePlanId'], $actual->offerDetails->basePlanId);
        $this->assertSame($data['offerDetails']['offerId'], $actual->offerDetails->offerId);
        $this->assertSame($data['deferredItemReplacement']['productId'], $actual->deferredItemReplacement->productId);
        $this->assertNotNull($actual->signupPromotion);
        $this->assertNotNull($actual->signupPromotion->oneTimeCode);
        $this->assertSame(
            $data['autoRenewingPlan']['recurringPrice']['currencyCode'],
            $actual->autoRenewingPlan->recurringPrice->currencyCode
        );
        $this->assertSame(
            $data['autoRenewingPlan']['recurringPrice']['units'],
            $actual->autoRenewingPlan->recurringPrice->units
        );
        $this->assertSame(
            $data['autoRenewingPlan']['recurringPrice']['nanos'],
            $actual->autoRenewingPlan->recurringPrice->nanos
        );
        $this->assertSame(
            $data['autoRenewingPlan']['priceChangeDetails']['newPrice']['currencyCode'],
            $actual->autoRenewingPlan->priceChangeDetails->newPrice->currencyCode
        );
        $this->assertSame(
            $data['autoRenewingPlan']['priceChangeDetails']['newPrice']['units'],
            $actual->autoRenewingPlan->priceChangeDetails->newPrice->units
        );
        $this->assertSame(
            $data['autoRenewingPlan']['priceChangeDetails']['newPrice']['nanos'],
            $actual->autoRenewingPlan->priceChangeDetails->newPrice->nanos
        );
        $this->assertSame(
            $data['autoRenewingPlan']['priceChangeDetails']['priceChangeMode'],
            $actual->autoRenewingPlan->priceChangeDetails->priceChangeMode
        );
        $this->assertSame(
            $data['autoRenewingPlan']['priceChangeDetails']['priceChangeState'],
            $actual->autoRenewingPlan->priceChangeDetails->priceChangeState
        );
        $this->assertSame(
            $data['autoRenewingPlan']['priceChangeDetails']['expectedNewPriceChargeTime'],
            $actual->autoRenewingPlan->priceChangeDetails->expectedNewPriceChargeTime->originalValue
        );
        $this->assertSame(
            $data['autoRenewingPlan']['installmentDetails']['initialCommittedPaymentsCount'],
            $actual->autoRenewingPlan->installmentDetails->initialCommittedPaymentsCount
        );
        $this->assertSame(
            $data['autoRenewingPlan']['installmentDetails']['subsequentCommittedPaymentsCount'],
            $actual->autoRenewingPlan->installmentDetails->subsequentCommittedPaymentsCount
        );
        $this->assertSame(
            $data['autoRenewingPlan']['installmentDetails']['remainingCommittedPaymentsCount'],
            $actual->autoRenewingPlan->installmentDetails->remainingCommittedPaymentsCount
        );
        $this->assertNotNull($actual->autoRenewingPlan->installmentDetails->pendingCancellation);
        $this->assertNotNull($actual->offerPhase);
        $this->assertNotNull($actual->offerPhase->freeTrial);
    }

    #[Test]
    public function instantiation_with_required_fields(): void
    {
        $data = [
            'productId' => $this->faker->word(),
        ];

        $actual = $this->normalizer->normalize($data, SubscriptionPurchaseLineItem::class);

        $this->assertSame($data['productId'], $actual->productId);
        $this->assertNull($actual->expiryTime);
        $this->assertNull($actual->offerDetails);
        $this->assertNull($actual->latestSuccessfulOrderId);
        $this->assertNull($actual->autoRenewingPlan);
        $this->assertNull($actual->prepaidPlan);
        $this->assertNull($actual->deferredItemReplacement);
        $this->assertNull($actual->signupPromotion);
    }
}
