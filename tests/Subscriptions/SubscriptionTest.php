<?php

namespace Imdhemy\GooglePlay\Tests\Subscriptions;

use Imdhemy\GooglePlay\ClientFactory;
use Imdhemy\GooglePlay\Subscriptions\Subscription;
use Imdhemy\GooglePlay\Subscriptions\SubscriptionPurchase;
use Imdhemy\GooglePlay\Tests\TestCase;

class SubscriptionTest extends TestCase
{
    /**
     * @var Subscription
     */
    private $subscription;

    protected function setUp(): void
    {
        parent::setUp();

        $client = ClientFactory::create([ClientFactory::SCOPE_ANDROID_PUBLISHER]);
        $packageName = 'com.twigano.v2';
        $subscriptionId = 'week_premium';
        $token = 'biakahdmblijpjncbijdicac.AO-J1OyEeH6JlhqDSPVIBxpQhG9iFDyz8cVLNx5uLjmLphKmKWjnKpA4d8Q3aDDGRMc-VxQ7IkPTgnTx37NcCWNBkSmxKi1nKAYmc3CyFw21pgHps4dQmJo';

        $this->subscription = new Subscription($client, $packageName, $subscriptionId, $token);
    }

    /**
     * @test
     */
    public function test_get_method()
    {
        $this->assertInstanceOf(SubscriptionPurchase::class, $this->subscription->get());
    }

    /**
     * @test
     */
    public function test_acknowledge()
    {
        $this->subscription->acknowledge();
        $this->assertTrue($this->subscription->get()->getAcknowledgementState()->isAcknowledged());
    }
}
