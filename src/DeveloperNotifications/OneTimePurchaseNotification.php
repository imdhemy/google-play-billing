<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;

class OneTimePurchaseNotification implements NotificationPayload
{
    public const ONE_TIME_PRODUCT_PURCHASED = 1;
    public const ONE_TIME_PRODUCT_CANCELED = 2;

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
     * @return static
     */
    public static function create(array $attributes): self
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
