<?php


namespace Imdhemy\GooglePlay\DeveloperNotifications;

class OneTimePurchaseNotification
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
}
