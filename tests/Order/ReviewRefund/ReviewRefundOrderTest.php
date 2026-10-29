<?php

declare(strict_types=1);

namespace Tests\Order\ReviewRefund;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Exception\UnexpectedResponseException;
use Imdhemy\GooglePlay\Order\Model\CoarseLocation;
use Imdhemy\GooglePlay\Order\Model\ConsumptionUsageEvent;
use Imdhemy\GooglePlay\Order\Model\RefundPreference;
use Imdhemy\GooglePlay\Order\ReviewRefund\ReviewRefundOrder;
use Imdhemy\GooglePlay\Order\ReviewRefund\ReviewRefundOrderRequest;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ReviewRefundOrderTest extends TestCase
{
    private const string URI = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.example.app/orders/GPA.1234-5678-9012-34567:reviewrefund';

    #[Test]
    public function it_sends_the_required_refund_review_fields(): void
    {
        $history = [];
        $client = $this->mockClient([new Response()], $history);
        $sut = new ReviewRefundOrder(client: $client, serializer: $this->serializer);
        $request = new ReviewRefundOrderRequest(
            packageName: 'com.example.app',
            orderId: 'GPA.1234-5678-9012-34567',
            pendingRefundToken: 'pending-refund-token',
            sampleContentProvided: false,
            refundPreference: RefundPreference::NEUTRAL,
        );

        $sut->execute($request);

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: self::URI,
                body: '{"pendingRefundToken":"pending-refund-token","sampleContentProvided":false,"refundPreference":"NEUTRAL"}',
            ),
        );
    }

    #[Test]
    public function it_sends_the_consumption_details_when_provided(): void
    {
        $history = [];
        $client = $this->mockClient([new Response()], $history);
        $sut = new ReviewRefundOrder(client: $client, serializer: $this->serializer);
        $request = new ReviewRefundOrderRequest(
            packageName: 'com.example.app',
            orderId: 'GPA.1234-5678-9012-34567',
            pendingRefundToken: 'pending-refund-token',
            sampleContentProvided: true,
            refundPreference: RefundPreference::DECLINE,
            consumptionPercentageMilliunits: 45200,
            consumptionUsageEvents: [
                new ConsumptionUsageEvent(
                    obfuscatedAccountId: 'account-1',
                    obfuscatedProfileId: 'profile-1',
                    consumptionTime: '2014-10-02T15:01:23Z',
                    ipAddress: '203.0.113.7',
                    consumptionItemDescription: 'Watched episode 3',
                    location: new CoarseLocation(
                        regionCode: 'ES',
                        administrativeArea: 'Madrid',
                        locality: 'Madrid',
                        sublocality: 'Centro',
                    ),
                ),
                new ConsumptionUsageEvent(location: new CoarseLocation(regionCode: 'CH')),
            ],
        );

        $sut->execute($request);

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: self::URI,
                body: '{"pendingRefundToken":"pending-refund-token","sampleContentProvided":true,"refundPreference":"DECLINE",'
                    .'"consumptionPercentageMilliunits":45200,"consumptionUsageEvents":['
                    .'{"obfuscatedAccountId":"account-1","obfuscatedProfileId":"profile-1","consumptionTime":"2014-10-02T15:01:23Z",'
                    .'"ipAddress":"203.0.113.7","consumptionItemDescription":"Watched episode 3",'
                    .'"location":{"regionCode":"ES","administrativeArea":"Madrid","locality":"Madrid","sublocality":"Centro"}},'
                    .'{"location":{"regionCode":"CH"}}]}',
            ),
        );
    }

    #[Test]
    public function it_throws_an_unexpected_response_exception_for_an_unsuccessful_response(): void
    {
        $errorBody = '{"error":{"code":400,"message":"The refund request is no longer pending.","status":"FAILED_PRECONDITION"}}';
        $client = $this->mockClient(new Response(400, ['Content-Type' => 'application/json'], $errorBody));
        $sut = new ReviewRefundOrder(client: $client, serializer: $this->serializer);
        $request = new ReviewRefundOrderRequest(
            packageName: 'com.example.app',
            orderId: 'GPA.1234-5678-9012-34567',
            pendingRefundToken: 'pending-refund-token',
            sampleContentProvided: false,
            refundPreference: RefundPreference::APPROVE,
        );

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage('Unexpected response for orders.reviewrefund: HTTP 400.');

        $sut->execute($request);
    }
}
