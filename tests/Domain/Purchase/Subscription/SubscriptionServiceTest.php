<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\RevocationContext;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscriptionService;
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
}
