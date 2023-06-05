<?php

namespace Imdhemy\GooglePlay\ValueObjects\V2;

use JsonSerializable;

/**
 * Subscription purchase class
 * Information associated with purchases made with 'Subscribe with Google'.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#SubscribeWithGoogleInfo
 */
class SubscribeWithGoogleInfo implements JsonSerializable
{

    /**
     * @var string|null
     */
    protected $profileId;

    /**
     * @var string|null
     */
    protected $profileName;

    /**
     * @var string|null
     */
    protected $emailAddress;

    /**
     * @var string|null
     */
    protected $givenName;

    /**
     * @var string|null
     */
    protected $familyName;


    /**
     * @var array
     */
    protected $rawData;

    protected $casts = [];

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

    public function getProfileId(): ?string
    {
        return $this->profileId;
    }

    public function getProfileName(): ?string
    {
        return $this->profileName;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
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
