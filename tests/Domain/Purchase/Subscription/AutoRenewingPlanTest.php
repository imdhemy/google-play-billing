<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\AutoRenewingPlan;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\InstallmentPlan;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscriptionItemPriceChangeDetails;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Tests\TestCase;

final class AutoRenewingPlanTest extends TestCase
{
    /** @test */
    public function instantiate(): void
    {
        $data = [
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
        ];

        $actual = $this->normalizer->normalize($data, AutoRenewingPlan::class);

        $this->assertInstanceOf(AutoRenewingPlan::class, $actual);
        $this->assertTrue($actual->autoRenewEnabled);
        $this->assertInstanceOf(Money::class, $actual->recurringPrice);
        $this->assertInstanceOf(SubscriptionItemPriceChangeDetails::class, $actual->priceChangeDetails);
        $this->assertInstanceOf(InstallmentPlan::class, $actual->installmentDetails);
    }

    /** @test */
    public function instantiate_with_recurring_price_only(): void
    {
        $data = [
            'recurringPrice' => [
                'currencyCode' => $this->faker->currencyCode(),
                'units' => (string)$this->faker->randomNumber(5),
                'nanos' => $this->faker->randomNumber(5),
            ],
        ];

        $actual = $this->normalizer->normalize($data, AutoRenewingPlan::class);

        $this->assertInstanceOf(AutoRenewingPlan::class, $actual);
        $this->assertNull($actual->autoRenewEnabled);
        $this->assertInstanceOf(Money::class, $actual->recurringPrice);
        $this->assertNull($actual->priceChangeDetails);
        $this->assertNull($actual->installmentDetails);
    }
}
