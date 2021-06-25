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
        $packageName = 'com.simpleclick.lifebox';
        $subscriptionId = 'price_1iiecwkkjlge9hvdjee3f2nf';
        $token = 'golbkblippbhphiippecihjm.AO-J1OwI8CmhowKXY5NrJeLMrucZLpryCw9EDpPnN4NOC29xES--VHnb_n2b0WUA_sAH1yrcqf3QBEmgbOO6-bnAiphresT9JuSAYiqky2sWZg54dxt5LNI';

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
        $this->assertTrue($this->subscription->get()->getAcknowledgementState()->isAcknowledged());
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function test_cancel()
    {
        $this->assertEmpty($this->subscription->cancel());
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function test_refund()
    {
        $this->assertEmpty($this->subscription->refund());
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function test_revoke()
    {
        $this->assertEmpty($this->subscription->revoke());
    }
}
