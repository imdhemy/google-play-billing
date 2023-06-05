<?php

namespace Imdhemy\GooglePlay\ValueObjects\V2;

use JsonSerializable;

/**
 * Subscription purchase class
 * Information related to an auto renewing plan.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#AutoRenewingPlan
 */
class AutoRenewingPlan implements JsonSerializable
{

    /**
     * @var bool|null
     */
    protected $autoRenewEnabled;

    /**
     * @var SubscriptionItemPriceChangeDetails|null
     */
    protected $priceChangeDetails;


    protected $casts = [
        'priceChangeDetails' => SubscriptionItemPriceChangeDetails::class,
    ];

    /**
     * @var array
     */
    protected $rawData;

    /**
     * Subscription Purchase Constructor.
     */
    public function __construct(array $rawData = [])
    {
        $attributes = array_keys(get_class_vars(self::class));
        foreach ($attributes as $attribute) {
            if (isset($responseBody[$attribute])) {
                if (isset($this->casts[$attribute])) {
                    $this->$attribute = $this->casts[$attribute]::fromArray($responseBody[$attribute]);
                    continue;
                }
                $this->$attribute = $responseBody[$attribute];
            }
        }
        $this->rawData = $rawData;
    }

    public function getAutoRenewEnabled(): bool
    {
        return $this->autoRenewEnabled;
    }

    public function getPriceChangeDetails(): SubscriptionItemPriceChangeDetails
    {
        return $this->priceChangeDetails;
    }


    /**
     * @param array $responseBody
     * @return static[]|static
     */
    public static function fromArray(array $responseBody): self|array
    {
        if (isset($responseBody[0]) && is_array($responseBody[0])) {
            return array_map('fromArray', $responseBody);
        }
        return new self($responseBody);
    }

    public function getPlainResponse(): array
    {
        return $this->rawData;
    }

    public function toArray(): array
    {
        return $this->getPlainResponse();
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
