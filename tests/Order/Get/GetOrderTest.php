<?php

declare(strict_types=1);

namespace Tests\Order\Get;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Exception\UnexpectedResponseException;
use Imdhemy\GooglePlay\Order\Get\GetOrder;
use Imdhemy\GooglePlay\Order\Get\GetOrderRequest;
use Imdhemy\GooglePlay\Order\Model\BuyerAddress;
use Imdhemy\GooglePlay\Order\Model\CancellationEvent;
use Imdhemy\GooglePlay\Order\Model\FreeTrialDetails;
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

final class GetOrderTest extends TestCase
{
    private const string URI = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.example.app/orders/GPA.1234-5678-9012-34567';

    #[Test]
    public function it_sends_a_get_request_for_the_order(): void
    {
        $history = [];
        $client = $this->mockClient([new Response(body: '{}')], $history);
        $sut = new GetOrder(client: $client, normalizer: $this->normalizer);

        $sut->execute(new GetOrderRequest(packageName: 'com.example.app', orderId: 'GPA.1234-5678-9012-34567'));

        $this->assertClientSentRequest(history: $history, request: new Request(method: 'GET', uri: self::URI));
    }

    #[Test]
    public function it_maps_every_documented_order_field(): void
    {
        $client = $this->mockClient(new Response(body: (string)json_encode([
            'orderId' => 'GPA.1234-5678-9012-34567',
            'purchaseToken' => 'purchase-token',
            'state' => 'PARTIALLY_REFUNDED',
            'createTime' => '2026-01-02T03:04:05Z',
            'lastEventTime' => '2026-01-09T10:11:12.5Z',
            'buyerAddress' => ['buyerPostcode' => '28001', 'buyerState' => 'Madrid', 'buyerCountry' => 'ES'],
            'total' => self::money('9', 990000000),
            'tax' => self::money('1', 730000000),
            'orderDetails' => ['taxInclusive' => true],
            'orderHistory' => [
                'processedEvent' => ['eventTime' => '2026-01-02T03:04:06Z'],
                'cancellationEvent' => ['eventTime' => '2026-01-08T00:00:00Z'],
                'refundEvent' => [
                    'eventTime' => '2026-01-09T10:11:12.5Z',
                    'refundDetails' => ['total' => self::money('4', 0), 'tax' => self::money('0', 690000000)],
                    'refundReason' => 'CHARGEBACK',
                ],
                'partialRefundEvents' => [[
                    'createTime' => '2026-01-05T00:00:00Z',
                    'processTime' => '2026-01-06T00:00:00Z',
                    'state' => 'PROCESSED_SUCCESSFULLY',
                    'refundDetails' => ['total' => self::money('1', 0), 'tax' => self::money('0', 170000000)],
                ]],
            ],
            'lineItems' => [
                [
                    'productTitle' => 'Monthly plan',
                    'productId' => 'monthly001',
                    'listingPrice' => self::money('9', 990000000),
                    'total' => self::money('9', 990000000),
                    'tax' => self::money('1', 730000000),
                    'subscriptionDetails' => [
                        'basePlanId' => 'monthly',
                        'offerId' => 'trial',
                        'offerPhase' => 'FREE_TRIAL',
                        'offerPhaseDetails' => [
                            'freeTrialDetails' => (object)[],
                            'prorationPeriodDetails' => ['originalOfferPhase' => 'BASE'],
                        ],
                        'servicePeriodStartTime' => '2026-01-02T03:04:05Z',
                        'servicePeriodEndTime' => '2026-02-02T03:04:05Z',
                    ],
                ],
                [
                    'productId' => 'coins',
                    'oneTimePurchaseDetails' => [
                        'quantity' => 3,
                        'offerId' => 'bundle',
                        'purchaseOptionId' => 'rent',
                        'rentalDetails' => (object)[],
                        'preorderDetails' => (object)[],
                    ],
                ],
                ['productId' => 'com.example.app', 'paidAppDetails' => (object)[]],
            ],
            'salesChannel' => 'IN_APP',
            'pointsDetails' => [
                'pointsOfferId' => 'points-offer',
                'pointsSpent' => '9007199254740993',
                'pointsDiscountRateMicros' => '250000',
                'pointsCouponValue' => self::money('2', 0),
            ],
            'developerRevenueInBuyerCurrency' => self::money('7', 0),
        ])));
        $sut = new GetOrder(client: $client, normalizer: $this->normalizer);

        $response = $sut->execute(new GetOrderRequest(packageName: 'com.example.app', orderId: 'GPA.1234-5678-9012-34567'));

        $this->assertEquals(new Order(
            orderId: 'GPA.1234-5678-9012-34567',
            purchaseToken: 'purchase-token',
            state: OrderState::PARTIALLY_REFUNDED,
            createTime: new DateTimeImmutable('2026-01-02T03:04:05Z'),
            lastEventTime: new DateTimeImmutable('2026-01-09T10:11:12.5Z'),
            buyerAddress: new BuyerAddress(buyerPostcode: '28001', buyerState: 'Madrid', buyerCountry: 'ES'),
            total: new Money('EUR', '9', 990000000),
            tax: new Money('EUR', '1', 730000000),
            orderDetails: new OrderDetails(taxInclusive: true),
            orderHistory: new OrderHistory(
                processedEvent: new ProcessedEvent(eventTime: new DateTimeImmutable('2026-01-02T03:04:06Z')),
                cancellationEvent: new CancellationEvent(eventTime: new DateTimeImmutable('2026-01-08T00:00:00Z')),
                refundEvent: new RefundEvent(
                    eventTime: new DateTimeImmutable('2026-01-09T10:11:12.5Z'),
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
                        offerPhaseDetails: new OfferPhaseDetails(
                            freeTrialDetails: new FreeTrialDetails(),
                            prorationPeriodDetails: new ProrationPeriodDetails(originalOfferPhase: OfferPhase::BASE),
                        ),
                        servicePeriodStartTime: new DateTimeImmutable('2026-01-02T03:04:05Z'),
                        servicePeriodEndTime: new DateTimeImmutable('2026-02-02T03:04:05Z'),
                    ),
                ),
                new LineItem(
                    productId: 'coins',
                    oneTimePurchaseDetails: new OneTimePurchaseDetails(
                        quantity: 3,
                        offerId: 'bundle',
                        purchaseOptionId: 'rent',
                        rentalDetails: new RentalDetails(),
                        preorderDetails: new PreorderDetails(),
                    ),
                ),
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
        ), $response->order);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $client = $this->mockClient(new Response(body: '{"orderId":"GPA.1234-5678-9012-34567","state":"PENDING"}'));
        $sut = new GetOrder(client: $client, normalizer: $this->normalizer);

        $response = $sut->execute(new GetOrderRequest(packageName: 'com.example.app', orderId: 'GPA.1234-5678-9012-34567'));

        $this->assertEquals(new Order(orderId: 'GPA.1234-5678-9012-34567', state: OrderState::PENDING), $response->order);
    }

    #[Test]
    public function it_throws_an_unexpected_response_exception_for_an_unsuccessful_response(): void
    {
        $errorBody = '{"error":{"code":404,"message":"Order not found.","status":"NOT_FOUND"}}';
        $client = $this->mockClient(new Response(404, ['Content-Type' => 'application/json'], $errorBody));
        $sut = new GetOrder(client: $client, normalizer: $this->normalizer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage('Unexpected response for orders.get: HTTP 404.');

        $sut->execute(new GetOrderRequest(packageName: 'com.example.app', orderId: 'GPA.1234-5678-9012-34567'));
    }

    /**
     * @return array{currencyCode: string, units: string, nanos: int}
     */
    private static function money(string $units, int $nanos): array
    {
        return ['currencyCode' => 'EUR', 'units' => $units, 'nanos' => $nanos];
    }
}
