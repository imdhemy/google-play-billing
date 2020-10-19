<?php


namespace Imdhemy\GooglePlay\DeveloperNotifications;

class SubscriptionNotification
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
     * @param string $version
     * @param int $notificationType
     * @param string $purchaseToken
     * @param string $subscriptionId
     */
    public function __construct(
        string $version,
        int $notificationType,
        string $purchaseToken,
        string $subscriptionId
    ) {
        $this->version = $version;
        $this->notificationType = $notificationType;
        $this->purchaseToken = $purchaseToken;
        $this->subscriptionId = $subscriptionId;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return int
     */
    public function getNotificationType(): int
    {
        return $this->notificationType;
    }

    /**
     * @return string
     */
    public function getPurchaseToken(): string
    {
        return $this->purchaseToken;
    }

    /**
     * @return string
     */
    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }
}
