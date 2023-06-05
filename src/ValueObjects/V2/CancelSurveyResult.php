<?php

namespace Imdhemy\GooglePlay\ValueObjects\V2;

use JsonSerializable;

/**
 * Subscription purchase class
 * Result of the cancel survey when the subscription was canceled by the user.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#CancelSurveyResult
 */
class CancelSurveyResult implements JsonSerializable
{

    /**
     * @var string|null
     */
    protected $reason;

    /**
     * @var string|null
     */
    protected $reasonUserInput;

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

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function getReasonUserInput(): ?string
    {
        return $this->reasonUserInput;
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
