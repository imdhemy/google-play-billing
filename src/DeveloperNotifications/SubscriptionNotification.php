<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;

/**
 * SubscriptionNotification Class
 * Subscription notification
 * {@link https://developer.android.com/google/play/billing/integrate}
 * {@https://developer.android.com/google/play/billing/rtdn-reference#sub}.
 */
class SubscriptionNotification implements NotificationPayload
{
    public const SUBSCRIPTION_RECOVERED = 1;
    public const SUBSCRIPTION_RENEWED = 2;
    public const SUBSCRIPTION_CANCELED = 3;
    public const SUBSCRIPTION_PURCHASED = 4;
    public const SUBSCRIPTION_ON_HOLD = 5;
    public const SUBSCRIPTION_IN_GRACE_PERIOD = 6;
    public const SUBSCRIPTION_RESTARTED = 7;
    public const SUBSCRIPTION_PRICE_CHANGE_CONFIRMED = 8;
    public const SUBSCRIPTION_DEFERRED = 9;
    public const SUBSCRIPTION_PAUSED = 10;
    public const SUBSCRIPTION_PAUSE_SCHEDULE_CHANGED = 11;
    public const SUBSCRIPTION_REVOKED = 12;
    public const SUBSCRIPTION_EXPIRED = 13;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var int
     */
    protected $notificationType;

    /**
     * @var string
     */
    protected $purchaseToken;

    /**
     * @var string
     */
    protected $subscriptionId;

    /**
     * SubscriptionNotification constructor.
     */
    public function __construct(string $version, int $notificationType, string $purchaseToken, string $subscriptionId)
    {
        $this->version = $version;
        $this->notificationType = $notificationType;
        $this->purchaseToken = $purchaseToken;
        $this->subscriptionId = $subscriptionId;
    }

    public static function create(array $attributes): SubscriptionNotification
    {
        return new self(
            $attributes['version'],
            $attributes['notificationType'],
            $attributes['purchaseToken'],
            $attributes['subscriptionId']
        );
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getNotificationType(): int
    {
        return $this->notificationType;
    }

    public function getPurchaseToken(): string
    {
        return $this->purchaseToken;
    }

    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }

    public function getType(): string
    {
        return self::SUBSCRIPTION_NOTIFICATION;
    }
}
