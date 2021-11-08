<?php

namespace Imdhemy\GooglePlay\Tests\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;
use Imdhemy\GooglePlay\DeveloperNotifications\DeveloperNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\OneTimePurchaseNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\SubscriptionNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\TestNotification;
use Imdhemy\GooglePlay\Tests\TestCase;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Class DeveloperNotificationTest
 * @package Imdhemy\GooglePlay\Tests\DeveloperNotifications
 */
class DeveloperNotificationTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_parse_subscription_notification()
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

        $encodedData = base64_encode(json_encode($data));
        $notification = DeveloperNotification::parse($encodedData);

        $this->assertInstanceOf(DeveloperNotification::class, $notification);
        $this->assertInstanceOf(SubscriptionNotification::class, $notification->getPayload());
        $this->assertEquals(NotificationPayload::SUBSCRIPTION_NOTIFICATION, $notification->getType());
    }

    /**
     * @test
     */
    public function test_it_can_parse_one_time_purchase_notification()
    {
        $data = [
            'version' => '1.0',
            'packageName' => 'com.some.thing',
            'eventTimeMillis' => '1603051412791',
            'oneTimeProductNotification' => [
                'version' => '1.0',
                'notificationType' => NotificationPayload::ONE_TIME_PRODUCT_PURCHASED,
                'purchaseToken' => 'fake_purchase_token',
                'sku' => 'fake_sku',
            ],
        ];

        $encodedData = base64_encode(json_encode($data));
        $notification = DeveloperNotification::parse($encodedData);

        $this->assertInstanceOf(DeveloperNotification::class, $notification);
        $this->assertInstanceOf(OneTimePurchaseNotification::class, $notification->getPayload());
        $this->assertEquals(NotificationPayload::ONE_TIME_PRODUCT_NOTIFICATION, $notification->getType());
    }

    /**
     * @test
     */
    public function test_it_can_parse_test_notification()
    {
        $data = [
            'version' => '1.0',
            'packageName' => 'com.some.thing',
            'eventTimeMillis' => '1603051412791',
            'testNotification' => [
                'version' => '1.0',
            ],
        ];

        $encodedData = base64_encode(json_encode($data));
        $notification = DeveloperNotification::parse($encodedData);

        $this->assertInstanceOf(DeveloperNotification::class, $notification);
        $this->assertInstanceOf(TestNotification::class, $notification->getPayload());
        $this->assertEquals(NotificationPayload::TEST_NOTIFICATION, $notification->getType());
        $this->assertTrue($notification->isTestNotification());
    }

    /**
     * @test
     */
    public function test_getters()
    {
        $version = '1.0';
        $packageName = 'com.some.thing';
        $eventTimeMillis = '1603051412791';

        $data = [
            'version' => $version,
            'packageName' => $packageName,
            'eventTimeMillis' => $eventTimeMillis,
            'testNotification' => [
                'version' => $version,
            ],
        ];

        $encodedData = base64_encode(json_encode($data));
        $notification = DeveloperNotification::parse($encodedData);

        $this->assertEquals($version, $notification->getVersion());
        $this->assertEquals($packageName, $notification->getPackageName());
        $this->assertEquals(new Time($eventTimeMillis), $notification->getEventTime());
        $this->assertInstanceOf(NotificationPayload::class, $notification->getPayload());
    }
}
