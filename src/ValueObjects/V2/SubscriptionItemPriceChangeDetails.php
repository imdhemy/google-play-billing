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
    public function __construct(array $responseBody = [])
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
        $this->rawData = $responseBody;
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

    public static function fromArray(array $responseBody): self
    {
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
