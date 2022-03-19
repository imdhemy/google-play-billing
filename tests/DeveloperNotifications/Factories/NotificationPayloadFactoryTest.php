<?php

namespace Tests\DeveloperNotifications\Factories;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;
use Imdhemy\GooglePlay\DeveloperNotifications\Factories\NotificationPayloadFactory;
use Imdhemy\GooglePlay\DeveloperNotifications\OneTimePurchaseNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\SubscriptionNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\TestNotification;
use Tests\TestCase;

class NotificationPayloadFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_creates_one_time_purchase_payload()
    {
        $data = [
            'version' => '1.0',
            'packageName' => 'com.some.thing',
            'eventTimeMillis' => '1603051412791',
            'oneTimeProductNotification' => [
                'version' => '1.0',
                'notificationType' => OneTimePurchaseNotification::ONE_TIME_PRODUCT_PURCHASED,
                'purchaseToken' => 'fake_purchase_token',
                'sku' => 'fake_sku',
            ],
        ];

        $payload = NotificationPayloadFactory::create($data);
        $this->assertInstanceOf(NotificationPayload::class, $payload);
        $this->assertInstanceOf(OneTimePurchaseNotification::class, $payload);
    }

    /**
     * @test
     */
    public function test_it_creates_subscription_payload()
    {
        $data = [
            'version' => '1.0',
            'packageName' => 'com.some.thing',
            'eventTimeMillis' => '1603051412791',
            'subscriptionNotification' => [
                'version' => '1.0',
                'notificationType' => SubscriptionNotification::SUBSCRIPTION_RECOVERED,
                'purchaseToken' => 'fake_purchase_token',
                'subscriptionId' => 'yearly',
            ],
        ];

        $payload = NotificationPayloadFactory::create($data);
        $this->assertInstanceOf(NotificationPayload::class, $payload);
        $this->assertInstanceOf(SubscriptionNotification::class, $payload);
    }

    /**
     * @test
     */
    public function test_it_creates_a_test_payload()
    {
        $data = [
            'version' => '1.0',
            'packageName' => 'com.some.thing',
            'eventTimeMillis' => '1603051412791',
            'testNotification' => [
                'version' => '1.0',
            ],
        ];

        $payload = NotificationPayloadFactory::create($data);
        $this->assertInstanceOf(NotificationPayload::class, $payload);
        $this->assertInstanceOf(TestNotification::class, $payload);
    }
}
