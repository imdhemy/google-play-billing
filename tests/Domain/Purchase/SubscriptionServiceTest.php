<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase;

use Closure;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\CancellationType;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\RevocationContext;
use Imdhemy\GooglePlay\Domain\Purchase\SubscriptionService;
use Imdhemy\GooglePlay\Dto\DeferSubscriptionResponse;
use Imdhemy\GooglePlay\Exception\UnexpectedResponseException;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionDeferralInfo;
use Imdhemy\GooglePlay\ValueObjects\Time;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SubscriptionServiceTest extends TestCase
{
    #[Test]
    public function get(): void
    {
        $history = [];
        $packageName = 'com.example.app';
        $token = $this->faker->subscriptionToken();
        $client = $this->mockClient($this->faker->subscriptionPurchaseV2Response(), $history);
        $sut = new SubscriptionService(client: $client, normalizer: $this->normalizer, serializer: $this->serializer);

        $sut->get(packageName: $packageName, token: $token);

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'GET',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.example.app/purchases/subscriptionsv2/tokens/'.$token,
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ),
        );
    }

    #[Test]
    public function get_throws_an_unexpected_response_exception_for_an_unsuccessful_response(): void
    {
        $errorBody = '{"error":{"code":403,"message":"Permission denied","status":"PERMISSION_DENIED"}}';
        $client = $this->mockClient(new Response(403, ['Content-Type' => 'application/json'], $errorBody));
        $sut = new SubscriptionService(client: $client, normalizer: $this->normalizer, serializer: $this->serializer);

        $this->expectException(UnexpectedResponseException::class);

        $sut->get(packageName: 'com.example.app', token: 'fixture-token');
    }

    #[Test]
    public function revoke(): void
    {
        $history = [];
        $packageName = 'com.example.app';
        $token = $this->faker->subscriptionToken();
        $client = $this->mockClient([new Response()], $history);
        $sut = new SubscriptionService(client: $client, normalizer: $this->normalizer, serializer: $this->serializer);

        $sut->revoke(packageName: $packageName, token: $token, revocationContext: RevocationContext::forFullRefund());

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.example.app/purchases/subscriptionsv2/tokens/'.$token.':revoke',
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                body: '{"revocationContext":{"fullRefund":{}}}',
            ),
        );
    }

    #[Test]
    public function legacy_acknowledge(): void
    {
        $history = [];
        $packageName = 'com.example.app';
        $token = $this->faker->subscriptionToken();
        $developerPayload = 'AppSpecificInfo-UserID-12345';
        $client = $this->mockClient([new Response()], $history);
        $sut = new SubscriptionService(client: $client, normalizer: $this->normalizer, serializer: $this->serializer);

        $sut->legacyAcknowledge(packageName: $packageName, token: $token, developerPayload: $developerPayload);

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/'.$packageName.'/purchases/subscriptions/tokens/'.$token.':acknowledge',
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                body: '{"developerPayload":"AppSpecificInfo-UserID-12345"}',
            ),
        );
    }

    #[Test]
    public function legacy_cancel(): void
    {
        $history = [];
        $packageName = 'com.example.app';
        $token = $this->faker->subscriptionToken();
        $client = $this->mockClient([new Response()], $history);
        $cancellationType = $this->faker->randomElement(CancellationType::cases());
        $sut = new SubscriptionService(client: $client, normalizer: $this->normalizer, serializer: $this->serializer);

        $sut->legacyCancel(packageName: $packageName, token: $token, cancellationType: $cancellationType);

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/'.$packageName.'/purchases/subscriptions/tokens/'.$token.':cancel',
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                body: '{"cancellationType":"'.$cancellationType->value.'"}',
            )
        );
    }

    #[Test]
    public function legacy_defer(): void
    {
        $history = [];
        $client = $this->mockClient([new Response(200, [], '{"newExpiryTimeMillis": "1776004800000"}')], $history);
        $sut = new SubscriptionService(client: $client, normalizer: $this->normalizer, serializer: $this->serializer);
        $token = $this->faker->subscriptionToken();
        $packageName = 'com.example.app';
        $subscriptionId = 'monthly001';
        $deferralInfo = new SubscriptionDeferralInfo('1704067200000', '1735689600000');

        $actual = $sut->legacyDefer(
            packageName: $packageName,
            subscriptionId: $subscriptionId,
            token: $token,
            deferralInfo: $deferralInfo
        );

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/'.$packageName.'/purchases/subscriptions/'.$subscriptionId.'/tokens/'.$token.':defer',
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                body: '{"deferralInfo":{"expectedExpiryTimeMillis":"1704067200000","desiredExpiryTimeMillis":"1735689600000"}}',
            )
        );
        $this->assertEquals(new DeferSubscriptionResponse(new Time('1776004800000')), $actual);
    }

    #[Test]
    public function legacy_refund(): void
    {
        $history = [];
        $client = $this->mockClient([new Response()], $history);
        $packageName = 'com.example.app';
        $subscriptionId = 'monthly001';
        $token = $this->faker->subscriptionToken();
        $sut = new SubscriptionService(client: $client, normalizer: $this->normalizer, serializer: $this->serializer);

        $sut->legacyRefund(
            packageName: $packageName,
            subscriptionId: $subscriptionId,
            token: $token
        );

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/'.$packageName.'/purchases/subscriptions/'.$subscriptionId.'/tokens/'.$token.':refund',
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            )
        );
    }

    #[Test]
    #[DataProvider('provide_operations')]
    public function it_throws_an_unexpected_response_exception_for_an_unsuccessful_operation(
        string $operation,
        Closure $call,
    ): void {
        $errorBody = '{"error":{"code":400,"message":"The subscription purchase is not refundable.","status":"FAILED_PRECONDITION"}}';
        $client = $this->mockClient(new Response(400, ['Content-Type' => 'application/json'], $errorBody));
        $sut = new SubscriptionService(client: $client, normalizer: $this->normalizer, serializer: $this->serializer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf('Unexpected response for %s: HTTP 400.', $operation));

        $call($sut);
    }

    public static function provide_operations(): iterable
    {
        yield 'revoke' => [
            'purchases.subscriptionsv2.revoke',
            static fn (SubscriptionService $sut) => $sut->revoke('com.example.app', 'token', RevocationContext::forFullRefund()),
        ];
        yield 'legacy acknowledge' => [
            'purchases.subscriptions.acknowledge',
            static fn (SubscriptionService $sut) => $sut->legacyAcknowledge('com.example.app', 'token', 'payload'),
        ];
        yield 'legacy cancel' => [
            'purchases.subscriptions.cancel',
            static fn (SubscriptionService $sut) => $sut->legacyCancel('com.example.app', 'token', CancellationType::cases()[0]),
        ];
        yield 'legacy defer' => [
            'purchases.subscriptions.defer',
            static fn (SubscriptionService $sut) => $sut->legacyDefer(
                'com.example.app',
                'subscription_id',
                'token',
                new SubscriptionDeferralInfo('1704067200000', '1735689600000'),
            ),
        ];
        yield 'legacy refund' => [
            'purchases.subscriptions.refund',
            static fn (SubscriptionService $sut) => $sut->legacyRefund('com.example.app', 'subscription_id', 'token'),
        ];
    }
}
