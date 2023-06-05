<?php

namespace Imdhemy\GooglePlay\ValueObjects\V2;

use JsonSerializable;

/**
 * Subscription purchase class
 * Information specific to a subscription in paused state.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#PausedStateContext
 */
class PausedStateContext implements JsonSerializable
{

    /**
     * @var string|null
     */
    protected $autoResumeTime;

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

    public function getAutoResumeTime(): ?string
    {
        return $this->autoResumeTime;
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
