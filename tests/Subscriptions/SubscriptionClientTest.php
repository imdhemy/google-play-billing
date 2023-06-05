<?php

namespace Tests\Subscriptions;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\ClientFactory;
use Imdhemy\GooglePlay\Subscriptions\SubscriptionClient;
use Imdhemy\GooglePlay\Subscriptions\SubscriptionPurchase;
use Imdhemy\GooglePlay\ValueObjects\EmptyResponse;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionDeferralInfo;
use Imdhemy\GooglePlay\ValueObjects\Time;
use Tests\TestCase;

class SubscriptionClientTest extends TestCase
{
    /**
     * @var string
     */
    private $packageName;

    /**
     * @var string
     */
    private $subscriptionId;

    /**
     * @var string
     */
    private $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->packageName = 'com.some.thing';
        $this->subscriptionId = 'fake_id';
        $this->token = 'fake_token';
    }

    /**
     * @test
     *
     * @throws GuzzleException
     */
    public function get()
    {
        $response = new Response(200, [], '[]');
        $transactions = [];
        $client = ClientFactory::mock($response, $transactions);
        $subscriptionClient = $this->getSubscriptionClient($client);
        $this->assertInstanceOf(SubscriptionPurchase::class, $subscriptionClient->get());

        /** @var Request $request */
        $request = $transactions[0]['request'];
        $uri = $this->getEndpoint(SubscriptionClient::URI_GET);

        $this->assertEquals($uri, (string)$request->getUri());
    }

    /**
     * @test
     *
     * @throws GuzzleException
     */
    public function acknowledge()
    {
        $acknowledgeResponse = new Response(200, [], '[]');
        $getResponseBody = json_encode(
            ['acknowledgementState' => SubscriptionPurchase::ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED]
        );
        $getResponse = new Response(200, [], $getResponseBody);

        $transactions = [];
        $client = ClientFactory::mockQueue([$acknowledgeResponse, $getResponse], $transactions);
        $subscriptionClient = $this->getSubscriptionClient($client);

        $this->assertInstanceOf(EmptyResponse::class, $subscriptionClient->acknowledge());
        $this->assertEquals(
            SubscriptionPurchase::ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED,
            $subscriptionClient->get()
                ->getAcknowledgementState()
        );

        /** @var Request $request */
        $request = $transactions[0]['request'];
        $uri = $this->getEndpoint(SubscriptionClient::URI_ACKNOWLEDGE);

        $this->assertEquals($uri, (string)$request->getUri());
    }

    /**
     * @test
     *
     * @throws GuzzleException
     */
    public function cancel()
    {
        $cancelResponse = new Response();
        $transactions = [];
        $client = ClientFactory::mock($cancelResponse, $transactions);

        $subscriptionClient = $this->getSubscriptionClient($client);
        $this->assertInstanceOf(EmptyResponse::class, $subscriptionClient->cancel());

        $uri = $this->getEndpoint(SubscriptionClient::URI_CANCEL);
        /** @var Request $request */
        $request = $transactions[0]['request'];
        $this->assertEquals($uri, (string)$request->getUri());
    }

    /**
     * @test
     *
     * @throws GuzzleException
     */
    public function defer()
    {
        $desiredExpiryTimeMillis = $this->faker->dateTime->getTimestamp() * 1000;
        $deferResponse = new Response(200, [], json_encode(['newExpiryTimeMillis' => $desiredExpiryTimeMillis]));

        $transactions = [];
        $client = ClientFactory::mock($deferResponse, $transactions);
        $subscriptionClient = $this->getSubscriptionClient($client);

        $deferralInfo = new SubscriptionDeferralInfo(0, $desiredExpiryTimeMillis);
        $newExpiryTime = $subscriptionClient->defer($deferralInfo);

        $this->assertInstanceOf(Time::class, $newExpiryTime);
        $this->assertEquals($desiredExpiryTimeMillis, $newExpiryTime->getCarbon()->getTimestampMs());

        /** @var Request $request */
        $request = $transactions[0]['request'];
        $uri = $this->getEndpoint(SubscriptionClient::URI_DEFER);
        $this->assertEquals($uri, (string)$request->getUri());
    }

    /**
     * @test
     *
     * @throws GuzzleException
     */
    public function refund()
    {
        $refundResponse = new Response();
        $transactions = [];
        $client = ClientFactory::mock($refundResponse, $transactions);

        $subscriptionClient = new SubscriptionClient($client, $this->packageName, $this->subscriptionId, $this->token);

        $response = $subscriptionClient->refund();
        $this->assertInstanceOf(EmptyResponse::class, $response);

        $uri = sprintf(SubscriptionClient::URI_REFUND, $this->packageName, $this->subscriptionId, $this->token);

        /** @var Request $request */
        $request = $transactions[0]['request'];
        $this->assertEquals($uri, (string)$request->getUri());
    }

    /**
     * @test
     *
     * @throws GuzzleException
     */
    public function revoke()
    {
        $revokeResponse = new Response();
        $transactions = [];
        $client = ClientFactory::mock($revokeResponse, $transactions);

        $subscriptionClient = new SubscriptionClient($client, $this->packageName, $this->subscriptionId, $this->token);

        $response = $subscriptionClient->revoke();
        $this->assertInstanceOf(EmptyResponse::class, $response);

        $uri = sprintf(SubscriptionClient::URI_REVOKE, $this->packageName, $this->subscriptionId, $this->token);

        /** @var Request $request */
        $request = $transactions[0]['request'];
        $this->assertEquals($uri, (string)$request->getUri());
    }

    private function getSubscriptionClient(ClientInterface $client): SubscriptionClient
    {
        return new SubscriptionClient(
            $client,
            $this->packageName,
            $this->subscriptionId,
            $this->token
        );
    }

    private function getEndpoint(string $template): string
    {
        return sprintf($template, $this->packageName, $this->subscriptionId, $this->token);
    }
}
