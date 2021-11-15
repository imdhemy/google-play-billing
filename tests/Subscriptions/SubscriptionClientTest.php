<?php

namespace Imdhemy\GooglePlay\Tests\Subscriptions;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\ClientFactory;
use Imdhemy\GooglePlay\Subscriptions\SubscriptionClient;
use Imdhemy\GooglePlay\Subscriptions\SubscriptionPurchase;
use Imdhemy\GooglePlay\Tests\TestCase;
use Imdhemy\GooglePlay\ValueObjects\AcknowledgementState;

class SubscriptionClientTest extends TestCase
{
    /**
     * @test
     * @throws GuzzleException
     */
    public function test_get_method()
    {
        $client = ClientFactory::mock(new Response(200, [], json_encode([])));
        $subscriptionClient = new SubscriptionClient($client, 'com.some.thing', 'fake_id', 'fake_token');
        $this->assertInstanceOf(SubscriptionPurchase::class, $subscriptionClient->get());
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function test_acknowledge()
    {
        $acknowledgeResponse = new Response(200, [], json_encode([]));
        $getResponse = new Response(
            200, [], json_encode(['acknowledgementState' => AcknowledgementState::ACKNOWLEDGED])
        );
        $client = ClientFactory::mockQueue([$acknowledgeResponse, $getResponse]);
        $subscriptionClient = new SubscriptionClient($client, 'com.some.thing', 'fake_id', 'fake_token');

        $subscriptionClient->acknowledge();
        $this->assertTrue($subscriptionClient->get()->getAcknowledgementState()->isAcknowledged());
    }
}
