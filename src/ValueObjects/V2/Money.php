<?php

namespace Imdhemy\GooglePlay\ValueObjects\V2;

use JsonSerializable;

/**
 * Subscription purchase class
 * Offer details information related to a purchase line item.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#OfferDetails
 */
class Money implements JsonSerializable
{

    /**
     * @var string|null
     */
    protected $currencyCode;

    /**
     * @var string|null
     */
    protected $units;

    /**
     * @var int|null
     */
    protected $nanos;


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
                $this->$attribute = $responseBody[$attribute];
            }
        }

        $this->rawData = $rawData;
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

    public function getRawData(): array
    {
        return $this->rawData;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function getUnits(): ?string
    {
        return $this->units;
    }

    public function getNanos(): ?int
    {
        return $this->nanos;
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
