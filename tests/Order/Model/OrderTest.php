<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\BaseDetails;
use Imdhemy\GooglePlay\Order\Model\BuyerAddress;
use Imdhemy\GooglePlay\Order\Model\CancellationEvent;
use Imdhemy\GooglePlay\Order\Model\FreeTrialDetails;
use Imdhemy\GooglePlay\Order\Model\IntroductoryPriceDetails;
use Imdhemy\GooglePlay\Order\Model\LineItem;
use Imdhemy\GooglePlay\Order\Model\OfferPhase;
use Imdhemy\GooglePlay\Order\Model\OfferPhaseDetails;
use Imdhemy\GooglePlay\Order\Model\OneTimePurchaseDetails;
use Imdhemy\GooglePlay\Order\Model\Order;
use Imdhemy\GooglePlay\Order\Model\OrderDetails;
use Imdhemy\GooglePlay\Order\Model\OrderHistory;
use Imdhemy\GooglePlay\Order\Model\OrderState;
use Imdhemy\GooglePlay\Order\Model\PaidAppDetails;
use Imdhemy\GooglePlay\Order\Model\PartialRefundEvent;
use Imdhemy\GooglePlay\Order\Model\PartialRefundState;
use Imdhemy\GooglePlay\Order\Model\PointsDetails;
use Imdhemy\GooglePlay\Order\Model\PreorderDetails;
use Imdhemy\GooglePlay\Order\Model\ProcessedEvent;
use Imdhemy\GooglePlay\Order\Model\ProrationPeriodDetails;
use Imdhemy\GooglePlay\Order\Model\RefundDetails;
use Imdhemy\GooglePlay\Order\Model\RefundEvent;
use Imdhemy\GooglePlay\Order\Model\RefundReason;
use Imdhemy\GooglePlay\Order\Model\RentalDetails;
use Imdhemy\GooglePlay\Order\Model\SalesChannel;
use Imdhemy\GooglePlay\Order\Model\SubscriptionDetails;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OrderTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $response = $this->faker->orderResponse();

        $order = $this->normalizer->normalize(data: $response, type: Order::class);

        $this->assertEquals(new Order(
            orderId: 'GPA.1234-5678-9012-34567',
            purchaseToken: 'purchase-token',
            state: OrderState::PARTIALLY_REFUNDED,
            createTime: new DateTimeImmutable('2026-01-02T03:04:05Z'),
            lastEventTime: new DateTimeImmutable('2026-01-09T10:11:12.123456789Z'),
            buyerAddress: new BuyerAddress(buyerPostcode: '28001', buyerState: 'Madrid', buyerCountry: 'ES'),
            total: new Money('EUR', '9', 990000000),
            tax: new Money('EUR', '1', 730000000),
            orderDetails: new OrderDetails(taxInclusive: true),
            orderHistory: new OrderHistory(
                processedEvent: new ProcessedEvent(eventTime: new DateTimeImmutable('2026-01-02T03:04:06Z')),
                cancellationEvent: new CancellationEvent(eventTime: new DateTimeImmutable('2026-01-08T00:00:00Z')),
                refundEvent: new RefundEvent(
                    eventTime: new DateTimeImmutable('2026-01-09T10:11:12.123456789Z'),
                    refundDetails: new RefundDetails(total: new Money('EUR', '4', 0), tax: new Money('EUR', '0', 690000000)),
                    refundReason: RefundReason::CHARGEBACK,
                ),
                partialRefundEvents: [new PartialRefundEvent(
                    createTime: new DateTimeImmutable('2026-01-05T00:00:00Z'),
                    processTime: new DateTimeImmutable('2026-01-06T00:00:00Z'),
                    state: PartialRefundState::PROCESSED_SUCCESSFULLY,
                    refundDetails: new RefundDetails(total: new Money('EUR', '1', 0), tax: new Money('EUR', '0', 170000000)),
                )],
            ),
            lineItems: [
                new LineItem(
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
                ),
                new LineItem(productId: 'yearly001', subscriptionDetails: new SubscriptionDetails(basePlanId: 'yearly', offerPhase: OfferPhase::BASE, offerPhaseDetails: new OfferPhaseDetails(baseDetails: new BaseDetails()))),
                new LineItem(productId: 'weekly001', subscriptionDetails: new SubscriptionDetails(
                    basePlanId: 'weekly',
                    offerId: 'intro',
                    offerPhase: OfferPhase::INTRODUCTORY,
                    offerPhaseDetails: new OfferPhaseDetails(introductoryPriceDetails: new IntroductoryPriceDetails()),
                )),
                new LineItem(productId: 'premium001', subscriptionDetails: new SubscriptionDetails(
                    basePlanId: 'premium',
                    offerPhaseDetails: new OfferPhaseDetails(prorationPeriodDetails: new ProrationPeriodDetails(originalOfferPhase: OfferPhase::INTRODUCTORY)),
                )),
                new LineItem(productId: 'coins', oneTimePurchaseDetails: new OneTimePurchaseDetails(
                    quantity: 3,
                    offerId: 'bundle',
                    purchaseOptionId: 'rent',
                    rentalDetails: new RentalDetails(),
                    preorderDetails: new PreorderDetails(),
                )),
                new LineItem(productId: 'com.example.app', paidAppDetails: new PaidAppDetails()),
            ],
            salesChannel: SalesChannel::IN_APP,
            pointsDetails: new PointsDetails(
                pointsOfferId: 'points-offer',
                pointsSpent: '9007199254740993',
                pointsDiscountRateMicros: '250000',
                pointsCouponValue: new Money('EUR', '2', 0),
            ),
            developerRevenueInBuyerCurrency: new Money('EUR', '7', 0),
        ), $order);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $response = new Response(body: '{}');

        $order = $this->normalizer->normalize(data: $response, type: Order::class);

        $this->assertEquals(new Order(), $order);
    }
}
