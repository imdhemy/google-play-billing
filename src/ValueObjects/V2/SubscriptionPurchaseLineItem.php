<?php

namespace Imdhemy\GooglePlay\ValueObjects\V2;

use JsonSerializable;

/**
 * Subscription purchase class
 * Item-level info for a subscription purchase.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#SubscriptionPurchaseLineItem
 */
class SubscriptionPurchaseLineItem implements JsonSerializable
{
    /**
     * @var string|null
     */
    protected $productId;

    /**
     * @var string|null
     */
    protected $expiryTime;

    /**
     * @var AutoRenewingPlan|null
     */
    protected $autoRenewingPlan;

    /**
     * @var PrepaidPlan|null
     */
    protected $prepaidPlan;


    /**
     * @var OfferDetails|null
     */
    protected $offerDetails;

    /**
     * @var array
     */
    protected $rawData;

    protected $casts = [
        'autoRenewingPlan' => AutoRenewingPlan::class,
        'prepaidPlan' => PrepaidPlan::class,
        'offerDetails' => OfferDetails::class,
    ];

    /**
     * Subscription Purchase Constructor.
     */
    public function __construct(array $rawData = [])
    {
        $attributes = array_keys(get_class_vars(self::class));
        foreach ($attributes as $attribute) {
            if (isset($rawData[$attribute])) {
                if (isset($this->casts[$attribute])) {
                    $this->$attribute = $this->casts[$attribute]::fromArray($rawData[$attribute]);
                    continue;
                }
                $this->$attribute = $rawData[$attribute];
            }
        }
        $this->rawData = $rawData;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function getExpiryTime(): ?string
    {
        return $this->expiryTime;
    }

    public function getAutoRenewingPlan(): ?AutoRenewingPlan
    {
        return $this->autoRenewingPlan;
    }

    public function getPrepaidPlan(): ?PrepaidPlan
    {
        return $this->prepaidPlan;
    }

    public function getOfferDetails(): ?OfferDetails
    {
        return $this->offerDetails;
    }

    /**
     * @param array $responseBody
     * @return static[]|static
     */
    public static function fromArray(array $responseBody): self|array
    {
        if (isset($responseBody[0]) && is_array($responseBody[0])) {
            return array_map('self::fromArray', $responseBody);
        }
        return new self($responseBody);
    }

    public function getRawData(): array
    {
        return $this->rawData;
    }

    public function toArray(): array
    {
        return $this->getRawData();
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
