<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Builders;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;
use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\RealTimeDeveloperNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\DeveloperNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\OneTimePurchaseNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\SubscriptionNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\TestNotification;

/**
 * Class DeveloperNotificationBuilder
 * @package Imdhemy\GooglePlay\DeveloperNotifications\Builders
 */
final class DeveloperNotificationBuilder
{
    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $packageName;

    /**
     * @var int
     */
    private $eventTimeMillis;

    /**
     * @var NotificationPayload
     */
    private $payload;

    /**
     * @return static
     */
    public static function init(): self
    {
        return new self();
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return DeveloperNotificationBuilder
     */
    public function setVersion(string $version): DeveloperNotificationBuilder
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->packageName;
    }

    /**
     * @param string $packageName
     * @return DeveloperNotificationBuilder
     */
    public function setPackageName(string $packageName): DeveloperNotificationBuilder
    {
        $this->packageName = $packageName;

        return $this;
    }

    /**
     * @return int
     */
    public function getEventTimeMillis(): int
    {
        return $this->eventTimeMillis;
    }

    /**
     * @param int $eventTimeMillis
     * @return DeveloperNotificationBuilder
     */
    public function setEventTimeMillis(int $eventTimeMillis): DeveloperNotificationBuilder
    {
        $this->eventTimeMillis = $eventTimeMillis;

        return $this;
    }

    /**
     * @return NotificationPayload
     */
    public function getPayload(): NotificationPayload
    {
        return $this->payload;
    }

    /**
     * @param NotificationPayload $payload
     * @return DeveloperNotificationBuilder
     */
    public function setPayload(NotificationPayload $payload): DeveloperNotificationBuilder
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @param array $data
     * @return DeveloperNotificationBuilder
     */
    public function setPayloadFromArray(array $data): DeveloperNotificationBuilder
    {
        if (isset($data[NotificationPayload::ONE_TIME_PRODUCT_NOTIFICATION])) {
            $this->payload = OneTimePurchaseNotification::create($data[NotificationPayload::ONE_TIME_PRODUCT_NOTIFICATION]);

            return $this;
        }

        if (isset($data[NotificationPayload::SUBSCRIPTION_NOTIFICATION])) {
            $this->payload = SubscriptionNotification::create($data[NotificationPayload::SUBSCRIPTION_NOTIFICATION]);

            return $this;
        }

        $this->payload = new TestNotification($data['version']);

        return $this;
    }

    /**
     * @return RealTimeDeveloperNotification|DeveloperNotification
     */
    public function build(): RealTimeDeveloperNotification
    {
        return new DeveloperNotification($this);
    }
}
