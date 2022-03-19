<?php

namespace Tests\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;
use Imdhemy\GooglePlay\DeveloperNotifications\SubscriptionNotification;
use Tests\TestCase;

class SubscriptionNotificationTest extends TestCase
{
    private const TYPES = [
        SubscriptionNotification::SUBSCRIPTION_RECOVERED,
        SubscriptionNotification::SUBSCRIPTION_RENEWED,
        SubscriptionNotification::SUBSCRIPTION_CANCELED,
        SubscriptionNotification::SUBSCRIPTION_PURCHASED,
        SubscriptionNotification::SUBSCRIPTION_ON_HOLD,
        SubscriptionNotification::SUBSCRIPTION_IN_GRACE_PERIOD,
        SubscriptionNotification::SUBSCRIPTION_RESTARTED,
        SubscriptionNotification::SUBSCRIPTION_PRICE_CHANGE_CONFIRMED,
        SubscriptionNotification::SUBSCRIPTION_DEFERRED,
        SubscriptionNotification::SUBSCRIPTION_PAUSED,
        SubscriptionNotification::SUBSCRIPTION_PAUSE_SCHEDULE_CHANGED,
        SubscriptionNotification::SUBSCRIPTION_REVOKED,
        SubscriptionNotification::SUBSCRIPTION_EXPIRED,
    ];

    /**
     * @var string
     */
    private $version;

    /**
     * @var int
     */
    private $notificationType;

    /**
     * @var string
     */
    private $purchaseToken;

    /**
     * @var string
     */
    private $subscriptionId;

    /**
     * @var array
     */
    private $data;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->version = $this->faker->semver();
        $this->notificationType = $this->faker->randomElement(self::TYPES);
        $this->purchaseToken = $this->faker->linuxPlatformToken();
        $this->subscriptionId = $this->faker->word();

        $this->data = [
            'version' => $this->version,
            'notificationType' => $this->notificationType,
            'purchaseToken' => $this->purchaseToken,
            'subscriptionId' => $this->subscriptionId,
        ];
    }

    /**
     * @test
     */
    public function test_create()
    {
        $payload = SubscriptionNotification::create($this->data);
        $this->assertInstanceOf(SubscriptionNotification::class, $payload);
    }

    /**
     * @test
     */
    public function test_get_version()
    {
        $payload = SubscriptionNotification::create($this->data);
        $this->assertEquals($this->version, $payload->getVersion());
    }

    /**
     * @test
     */
    public function test_notification_type()
    {
        $payload = SubscriptionNotification::create($this->data);
        $this->assertEquals($this->notificationType, $payload->getNotificationType());
    }

    /**
     * @test
     */
    public function test_get_purchase_token()
    {
        $payload = SubscriptionNotification::create($this->data);
        $this->assertEquals($this->purchaseToken, $payload->getPurchaseToken());
    }

    /**
     * @test
     */
    public function test_get_subscription_id()
    {
        $payload = SubscriptionNotification::create($this->data);
        $this->assertEquals($this->subscriptionId, $payload->getSubscriptionId());
    }

    /**
     * @test
     */
    public function test_get_type()
    {
        $payload = SubscriptionNotification::create($this->data);
        $this->assertEquals(NotificationPayload::SUBSCRIPTION_NOTIFICATION, $payload->getType());
    }
}
