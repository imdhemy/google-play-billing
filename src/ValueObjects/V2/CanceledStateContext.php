<?php

namespace Imdhemy\GooglePlay\ValueObjects\V2;

use JsonSerializable;

/**
 * Subscription purchase class
 * Information specific to a subscription in canceled state.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#CanceledStateContext
 */
class CanceledStateContext implements JsonSerializable
{

    /**
     * @var UserInitiatedCancellation|null
     */
    protected $userInitiatedCancellation;

    /**
     * @var array|null
     */
    protected $systemInitiatedCancellation;

    /**
     * @var array|null
     */
    protected $developerInitiatedCancellation;

    /**
     * @var array|null
     */
    protected $replacementCancellation;

    /**
     * @var array
     */
    protected $rawData;

    protected $casts = [
        'userInitiatedCancellation' => UserInitiatedCancellation::class
    ];

    /**
     * Subscription Purchase Constructor.
     */
    public function __construct(array $responseBody = [])
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
        $this->rawData = $responseBody;
    }

    public function getUserInitiatedCancellation(): ?UserInitiatedCancellation
    {
        return $this->userInitiatedCancellation;
    }

    public function getSystemInitiatedCancellation(): ?array
    {
        return $this->systemInitiatedCancellation;
    }

    public function getDeveloperInitiatedCancellation(): ?array
    {
        return $this->developerInitiatedCancellation;
    }

    public function getReplacementCancellation(): ?array
    {
        return $this->replacementCancellation;
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
