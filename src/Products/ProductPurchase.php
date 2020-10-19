<?php


namespace Imdhemy\GooglePlay\Products;

use Imdhemy\GooglePlay\ValueObjects\AcknowledgementState;
use Imdhemy\GooglePlay\ValueObjects\ConsumptionState;
use Imdhemy\GooglePlay\ValueObjects\PurchaseState;
use Imdhemy\GooglePlay\ValueObjects\PurchaseType;
use Imdhemy\GooglePlay\ValueObjects\Time;

class ProductPurchase
{
    /**
     * @var string
     */
    protected $kind;

    /**
     * @var int
     */
    protected $purchaseTimeMillis;

    /**
     * @var int
     */
    protected $purchaseState;

    /**
     * @var int
     */
    protected $consumptionState;

    /**
     * @var string
     */
    protected $developerPayload;

    /**
     * @var string
     */
    protected $orderId;

    /**
     * @var int
     */
    protected $purchaseType;

    /**
     * @var int
     */
    protected $acknowledgementState;

    /**
     * @var string
     */
    protected $purchaseToken;

    /**
     * @var string
     */
    protected $productId;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $obfuscatedExternalAccountId;

    /**
     * @var string
     */
    protected $obfuscatedExternalProfileId;

    /**
     * @var string
     */
    protected $regionCode;

    /**
     * @param array $responseBody
     * @return self
     */
    public static function fromResponseBody(array $responseBody): self
    {
        $object = new self();

        $attributes = array_keys(get_class_vars(self::class));
        foreach ($attributes as $attribute) {
            if (isset($responseBody[$attribute])) {
                $object->$attribute = $responseBody[$attribute];
            }
        }

        return $object;
    }

    /**
     * @return string
     */
    public function getKind(): string
    {
        return $this->kind;
    }

    /**
     * @return Time
     */
    public function getPurchaseTime(): Time
    {
        return new Time($this->purchaseTimeMillis);
    }

    /**
     * @return PurchaseState
     */
    public function getPurchaseState(): PurchaseState
    {
        return new PurchaseState($this->purchaseState);
    }

    /**
     * @return ConsumptionState
     */
    public function getConsumptionState(): ConsumptionState
    {
        return new ConsumptionState($this->consumptionState);
    }

    /**
     * @return string
     */
    public function getDeveloperPayload(): string
    {
        return $this->developerPayload;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @return PurchaseType
     */
    public function getPurchaseType(): PurchaseType
    {
        return new PurchaseType($this->purchaseType);
    }

    /**
     * @return AcknowledgementState
     */
    public function getAcknowledgementState(): AcknowledgementState
    {
        return new AcknowledgementState($this->acknowledgementState);
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
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getObfuscatedExternalAccountId(): string
    {
        return $this->obfuscatedExternalAccountId;
    }

    /**
     * @return string
     */
    public function getObfuscatedExternalProfileId(): string
    {
        return $this->obfuscatedExternalProfileId;
    }

    /**
     * @return string
     */
    public function getRegionCode(): string
    {
        return $this->regionCode;
    }
}
