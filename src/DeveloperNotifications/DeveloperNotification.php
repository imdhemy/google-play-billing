<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\Builders\DeveloperNotificationBuilder;
use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;
use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\RealTimeDeveloperNotification;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Class DeveloperNotification
 * This class represents the Real-time developer notifications from Google
 * {@link https://developer.android.com/google/play/billing/rtdn-reference}.
 */
class DeveloperNotification implements RealTimeDeveloperNotification
{
    /**
     * The version of this notification.
     * Initially, this is "1.0". This version is distinct from other version fields.
     *
     * @var string
     */
    protected $version;

    /**
     * The package name of the application that this notification relates to
     * (for example, `com.some.thing`).
     *
     * @var string
     */
    protected $packageName;

    /**
     * The timestamp when the event occurred, in milliseconds since the Epoch.
     *
     * @var int
     */
    protected $eventTimeMillis;

    /**
     * This key holds one of three mutually exclusive types of notifications.
     *
     * - @see \Imdhemy\GooglePlay\DeveloperNotifications\SubscriptionNotification
     * - @see \Imdhemy\GooglePlay\DeveloperNotifications\OneTimePurchaseNotification
     * - @see \Imdhemy\GooglePlay\DeveloperNotifications\TestNotification
     *
     * @var NotificationPayload|OneTimePurchaseNotification|SubscriptionNotification|TestNotification
     */
    protected $payload;

    /**
     * DeveloperNotification constructor.
     */
    public function __construct(DeveloperNotificationBuilder $builder)
    {
        $this->version = $builder->getVersion();
        $this->packageName = $builder->getPackageName();
        $this->eventTimeMillis = $builder->getEventTimeMillis();
        $this->payload = $builder->getPayload();
    }

    /**
     * Parses the notification data into a developer notification
     * @param string $data
     * @return DeveloperNotification
     */
    public static function parse(string $data): DeveloperNotification
    {
        $decodedData = json_decode(base64_decode($data), true);

        return DeveloperNotificationBuilder::init()
            ->setVersion($decodedData['version'])
            ->setPackageName($decodedData['packageName'])
            ->setEventTimeMillis($decodedData['eventTimeMillis'])
            ->setPayloadFromArray($decodedData)
            ->build();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->payload->getType();
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->packageName;
    }

    /**
     * @return Time
     */
    public function getEventTime(): Time
    {
        return new Time($this->eventTimeMillis);
    }

    /**
     * @return int
     */
    public function getEventTimeMillis(): int
    {
        return $this->eventTimeMillis;
    }

    /**
     * @return NotificationPayload|OneTimePurchaseNotification|SubscriptionNotification|TestNotification
     */
    public function getPayload(): NotificationPayload
    {
        return $this->payload;
    }

    /**
     * @return bool
     */
    public function isTestNotification(): bool
    {
        return $this->payload instanceof TestNotification;
    }
}
