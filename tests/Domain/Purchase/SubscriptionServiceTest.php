<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\CancellationType;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\RevocationContext;
use Imdhemy\GooglePlay\Domain\Purchase\SubscriptionService;
use Imdhemy\GooglePlay\Dto\DeferSubscriptionResponse;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionDeferralInfo;
use Imdhemy\GooglePlay\ValueObjects\Time;
use Tests\TestCase;

final class SubscriptionServiceTest extends TestCase
{
    /** @test */
    public function get_subscription(): void
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

    /** @test */
    public function revoke_subscription(): void
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

    /** @test */
    public function legacy_acknowledge_subscription(): void
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

    /** @test */
    public function legacy_cancel_subscription(): void
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

    /** @test */
    public function legacy_defer_subscription(): void
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
}
