<?php

namespace Imdhemy\GooglePlay\ValueObjects\V2;

use JsonSerializable;

/**
 * Subscription purchase class
 * Offer details information related to a purchase line item.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#OfferDetails
 */
class OfferDetails implements JsonSerializable
{

    /**
     * @var string[]|null
     */
    protected $offerTags;

    /**
     * @var string|null
     */
    protected $basePlanId;

    /**
     * @var string|null
     */
    protected $offerId;


    /**
     * @var array
     */
    protected $rawData;

    protected $casts = [];

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

    /**
     * @ return string[]|null
     */
    public function getOfferTags(): ?array
    {
        return $this->offerTags;
    }

    public function getBasePlanId(): ?string
    {
        return $this->basePlanId;
    }

    public function getOfferId(): ?string
    {
        return $this->offerId;
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
