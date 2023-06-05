<?php

namespace Imdhemy\GooglePlay\ValueObjects\V2;

use JsonSerializable;

/**
 * Subscription purchase class
 * Price change related information of a subscription item.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#SubscriptionItemPriceChangeDetails
 */
class SubscriptionItemPriceChangeDetails implements JsonSerializable
{
    /**
     * @var Money|null
     */
    protected $newPrice;

    /**
     * @var string|null
     */
    protected $priceChangeMode;

    /**
     * @var string|null
     */
    protected $priceChangeState;

    /**
     * @var string|null
     */
    protected $expectedNewPriceChargeTime;

    /**
     * @var array
     */
    protected $rawData;

    protected $casts = [
        'newPrice' => Money::class,
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

    public function getNewPrice(): ?Money
    {
        return $this->newPrice;
    }

    public function getPriceChangeMode(): ?string
    {
        return $this->priceChangeMode;
    }

    public function getPriceChangeState(): ?string
    {
        return $this->priceChangeState;
    }

    public function getExpectedNewPriceChargeTime(): ?string
    {
        return $this->expectedNewPriceChargeTime;
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
