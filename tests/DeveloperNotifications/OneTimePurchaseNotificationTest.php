<?php

namespace Tests\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;
use Imdhemy\GooglePlay\DeveloperNotifications\OneTimePurchaseNotification;
use Tests\TestCase;

/**
 * Class OneTimePurchaseNotificationTest
 */
class OneTimePurchaseNotificationTest extends TestCase
{
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
    private $sku;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->version = $this->faker->semver();
        $this->notificationType = OneTimePurchaseNotification::ONE_TIME_PRODUCT_PURCHASED;
        $this->purchaseToken = $this->faker->linuxPlatformToken();
        $this->sku = $this->faker->word();

        $this->attributes = [
            'version' => $this->version,
            'notificationType' => $this->notificationType,
            'purchaseToken' => $this->purchaseToken,
            'sku' => $this->sku,
        ];
    }

    /**
     * @test
     */
    public function test_create()
    {
        $payload = OneTimePurchaseNotification::create($this->attributes);
        $this->assertInstanceOf(OneTimePurchaseNotification::class, $payload);
    }

    /**
     * @test
     */
    public function test_get_version()
    {
        $payload = OneTimePurchaseNotification::create($this->attributes);
        $this->assertEquals($this->version, $payload->getVersion());
    }

    /**
     * @test
     */
    public function test_get_notification_type()
    {
        $attributes = $this->attributes;
        $attributes['notificationType'] = OneTimePurchaseNotification::ONE_TIME_PRODUCT_CANCELED;
        $payload = OneTimePurchaseNotification::create($attributes);
        $this->assertEquals(OneTimePurchaseNotification::ONE_TIME_PRODUCT_CANCELED, $payload->getNotificationType());

        $payload = OneTimePurchaseNotification::create($this->attributes);
        $this->assertEquals(OneTimePurchaseNotification::ONE_TIME_PRODUCT_PURCHASED, $payload->getNotificationType());
        $this->assertEquals($this->notificationType, $payload->getNotificationType());
    }

    /**
     * @test
     */
    public function test_get_purchase_token()
    {
        $payload = OneTimePurchaseNotification::create($this->attributes);
        $this->assertEquals($this->purchaseToken, $payload->getPurchaseToken());
    }

    /**
     * @test
     */
    public function test_get_sku()
    {
        $payload = OneTimePurchaseNotification::create($this->attributes);
        $this->assertEquals($this->sku, $payload->getSku());
    }

    /**
     * @test
     */
    public function test_get_type()
    {
        $payload = OneTimePurchaseNotification::create($this->attributes);
        $this->assertEquals(NotificationPayload::ONE_TIME_PRODUCT_NOTIFICATION, $payload->getType());
    }
}
