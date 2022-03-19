<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;

/**
 * OneTimePurchaseNotification Class
 * One-time product notification
 * Note: A OneTimeProductNotification is sent only for some types of one-time purchases.
 * For more information, see Integrate the library into your app.
 * {@link https://developer.android.com/google/play/billing/integrate}
 * {@link https://developer.android.com/google/play/billing/rtdn-reference#one-time}
 */
class OneTimePurchaseNotification implements NotificationPayload
{
    public const ONE_TIME_PRODUCT_CANCELED = 2;
    public const ONE_TIME_PRODUCT_PURCHASED = 1;
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
    protected $sku;

    /**
     * OneTimePurchaseNotification constructor.
     * @param string $version
     * @param int $notificationType
     * @param string $purchaseToken
     * @param string $sku
     */
    public function __construct(string $version, int $notificationType, string $purchaseToken, string $sku)
    {
        $this->version = $version;
        $this->notificationType = $notificationType;
        $this->purchaseToken = $purchaseToken;
        $this->sku = $sku;
    }

    /**
     * @param array $attributes
     * @return OneTimePurchaseNotification
     */
    public static function create(array $attributes): OneTimePurchaseNotification
    {
        return new self(
            $attributes['version'],
            $attributes['notificationType'],
            $attributes['purchaseToken'],
            $attributes['sku']
        );
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
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return self::ONE_TIME_PRODUCT_NOTIFICATION;
    }
}
