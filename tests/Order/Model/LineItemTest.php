<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
use Imdhemy\GooglePlay\Order\Model\FreeTrialDetails;
use Imdhemy\GooglePlay\Order\Model\LineItem;
use Imdhemy\GooglePlay\Order\Model\OfferPhase;
use Imdhemy\GooglePlay\Order\Model\OfferPhaseDetails;
use Imdhemy\GooglePlay\Order\Model\OneTimePurchaseDetails;
use Imdhemy\GooglePlay\Order\Model\PaidAppDetails;
use Imdhemy\GooglePlay\Order\Model\PreorderDetails;
use Imdhemy\GooglePlay\Order\Model\RentalDetails;
use Imdhemy\GooglePlay\Order\Model\SubscriptionDetails;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class LineItemTest extends TestCase
{
    #[Test]
    public function it_normalizes_a_subscription_line_item(): void
    {
        $data = $this->faker->lineItemPayload('monthly001');

        $lineItem = $this->normalizer->normalize(data: $data, type: LineItem::class);

        $this->assertEquals(new LineItem(
            productTitle: 'Monthly plan',
            productId: 'monthly001',
            listingPrice: new Money('EUR', '9', 990000000),
            total: new Money('EUR', '9', 990000000),
            tax: new Money('EUR', '1', 730000000),
            subscriptionDetails: new SubscriptionDetails(
                basePlanId: 'monthly',
                offerId: 'trial',
                offerPhase: OfferPhase::FREE_TRIAL,
                offerPhaseDetails: new OfferPhaseDetails(freeTrialDetails: new FreeTrialDetails()),
                servicePeriodStartTime: new DateTimeImmutable('2026-01-02T03:04:05Z'),
                servicePeriodEndTime: new DateTimeImmutable('2026-02-02T03:04:05Z'),
            ),
        ), $lineItem);
    }

    #[Test]
    public function it_normalizes_a_one_time_purchase_line_item(): void
    {
        $data = $this->faker->lineItemPayload('coins');

        $lineItem = $this->normalizer->normalize(data: $data, type: LineItem::class);

        $this->assertEquals(new LineItem(productId: 'coins', oneTimePurchaseDetails: new OneTimePurchaseDetails(
            quantity: 3,
            offerId: 'bundle',
            purchaseOptionId: 'rent',
            rentalDetails: new RentalDetails(),
            preorderDetails: new PreorderDetails(),
        )), $lineItem);
    }

    #[Test]
    public function it_normalizes_a_paid_app_line_item(): void
    {
        $data = $this->faker->lineItemPayload('com.example.app');

        $lineItem = $this->normalizer->normalize(data: $data, type: LineItem::class);

        $this->assertEquals(new LineItem(productId: 'com.example.app', paidAppDetails: new PaidAppDetails()), $lineItem);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $lineItem = $this->normalizer->normalize(data: [], type: LineItem::class);

        $this->assertEquals(new LineItem(), $lineItem);
    }
}
