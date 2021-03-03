<?php

namespace Imdhemy\GooglePlay\Tests\Subscriptions;

use GuzzleHttp\Exception\GuzzleException;
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
        $packageName = 'com.twigano.fashion';
        $subscriptionId = 'week_premium';
        $token = 'fbfkmfikhhhgienojccgafoe.AO-J1OzzBrmgttPXhWuMXb6B371gmcDsrSVAZCvb9OGzd8PESkDNL-i3aOqpfHKVHUgtcbbfS53WH8KKAXncmPy5qHP_h3A8rQ';

        $this->subscription = new Subscription($client, $packageName, $subscriptionId, $token);
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function test_get_method()
    {
        $this->assertInstanceOf(SubscriptionPurchase::class, $this->subscription->get());
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function test_acknowledge()
    {
        $this->subscription->acknowledge();
        $this->assertTrue($this->subscription->get()->getAcknowledgementState()->isAcknowledged());
    }
}
