<?php

namespace Imdhemy\GooglePlay\Products;

use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Class ProductPurchase
 * @link https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.products#ProductPurchase
 */
class ProductPurchase
{
    public const PURCHASE_STATE_PURCHASED = 0;
    public const PURCHASE_STATE_CANCELED = 1;
    public const PURCHASE_STATE_PENDING = 2;

    public const CONSUMPTION_STATE_NOT_CONSUMED = 0;
    public const CONSUMPTION_STATE_CONSUMED = 1;

    public const PURCHASE_TYPE_TEST = 0;
    public const PURCHASE_TYPE_PROMO = 1;
    public const PURCHASE_TYPE_REWARDED = 2;

    public const ACKNOWLEDGEMENT_STATE_NOT_ACKNOWLEDGED = 0;
    public const ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED = 1;

    /**
     * @var string|null
     */
    protected $kind;

    /**
     * @var int|null
     */
    protected $purchaseTimeMillis;

    /**
     * @var int|null
     */
    protected $purchaseState;

    /**
     * @var int|null
     */
    protected $consumptionState;

    /**
     * @var string|null
     */
    protected $developerPayload;

    /**
     * @var string|null
     */
    protected $orderId;

    /**
     * @var int|null
     */
    protected $purchaseType;

    /**
     * @var int|null
     */
    protected $acknowledgementState;

    /**
     * @var string|null
     */
    protected $purchaseToken;

    /**
     * @var string|null
     */
    protected $productId;

    /**
     * @var int|null
     */
    protected $quantity;

    /**
     * @var string|null
     */
    protected $obfuscatedExternalAccountId;

    /**
     * @var string|null
     */
    protected $obfuscatedExternalProfileId;

    /**
     * @var string|null
     */
    protected $regionCode;

    /**
     * @var array
     */
    protected $plainResponse;

    /**
     * Product Purchase constructor
     * @param array $payload
     */
    public function __construct(array $payload = [])
    {
        $attributes = array_keys(get_class_vars(self::class));
        foreach ($attributes as $attribute) {
            if (isset($payload[$attribute])) {
                $this->$attribute = $payload[$attribute];
            }
        }

        $this->plainResponse = $payload;
    }

    /**
     * @param array $payload
     * @return self
     */
    public static function fromArray(array $payload = []): self
    {
        return new self($payload);
    }

    /**
     * @return string|null
     */
    public function getKind(): ?string
    {
        return $this->kind;
    }

    /**
     * @return Time|null
     */
    public function getPurchaseTime(): ?Time
    {
        return
            $this->purchaseTimeMillis ?
                new Time($this->purchaseTimeMillis) :
                null;
    }

    /**
     * @return int|null
     */
    public function getPurchaseTimeMillis(): ?int
    {
        return $this->purchaseTimeMillis;
    }

    /**
     * @return int|null
     */
    public function getPurchaseState(): ?int
    {
        return $this->purchaseState;
    }

    /**
     * @return int|null
     */
    public function getConsumptionState(): ?int
    {
        return $this->consumptionState;
    }

    /**
     * @return string|null
     */
    public function getDeveloperPayload(): ?string
    {
        return $this->developerPayload;
    }

    /**
     * @return string|null
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * @return int|null
     */
    public function getPurchaseType(): ?int
    {
        return $this->purchaseType;
    }

    /**
     * @return int|null
     */
    public function getAcknowledgementState(): ?int
    {
        return $this->acknowledgementState;
    }

    /**
     * @return string|null
     */
    public function getPurchaseToken(): ?string
    {
        return $this->purchaseToken;
    }

    /**
     * @return string|null
     */
    public function getProductId(): ?string
    {
        return $this->productId;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @return string|null
     */
    public function getObfuscatedExternalAccountId(): ?string
    {
        return $this->obfuscatedExternalAccountId;
    }

    /**
     * @return string|null
     */
    public function getObfuscatedExternalProfileId(): ?string
    {
        return $this->obfuscatedExternalProfileId;
    }

    /**
     * @return string|null
     */
    public function getRegionCode(): ?string
    {
        return $this->regionCode;
    }

    /**
     * @return array
     */
    public function getPlainResponse(): array
    {
        return $this->plainResponse;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->getPlainResponse();
    }
}
