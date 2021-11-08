<?php

namespace Imdhemy\GooglePlay\Products;

use Imdhemy\GooglePlay\ValueObjects\AcknowledgementState;
use Imdhemy\GooglePlay\ValueObjects\ConsumptionState;
use Imdhemy\GooglePlay\ValueObjects\PurchaseState;
use Imdhemy\GooglePlay\ValueObjects\PurchaseType;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Class ProductPurchase
 * @package Imdhemy\GooglePlay\Products
 */
class ProductPurchase
{
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
     * @param array $payload
     * @return self
     */
    public static function fromArray(array $payload): self
    {
        $object = new self();

        $attributes = array_keys(get_class_vars(self::class));
        foreach ($attributes as $attribute) {
            if (isset($payload[$attribute])) {
                $object->$attribute = $payload[$attribute];
            }
        }

        return $object;
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
     * @return Time|null
     */
    public function getPurchaseTimeMillis(): ?int
    {
        return $this->purchaseTimeMillis;
    }

    /**
     * @return PurchaseState|null
     */
    public function getPurchaseState(): ?PurchaseState
    {
        return
            $this->purchaseState ?
                new PurchaseState($this->purchaseState) :
                null;
    }

    /**
     * @return ConsumptionState|null
     */
    public function getConsumptionState(): ?ConsumptionState
    {
        return
            $this->consumptionState ?
                new ConsumptionState($this->consumptionState) :
                null;
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
     * @return PurchaseType|null
     */
    public function getPurchaseType(): ?PurchaseType
    {
        return
            $this->purchaseType ?
                new PurchaseType($this->purchaseType) :
                null;
    }

    /**
     * @return AcknowledgementState
     */
    public function getAcknowledgementState(): ?AcknowledgementState
    {
        return
            $this->acknowledgementState ?
                new AcknowledgementState($this->acknowledgementState) :
                null;
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
}
