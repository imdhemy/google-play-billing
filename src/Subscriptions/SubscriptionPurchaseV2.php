<?php

namespace Imdhemy\GooglePlay\Subscriptions;

use Imdhemy\GooglePlay\ValueObjects\V2\CanceledStateContext;
use Imdhemy\GooglePlay\ValueObjects\V2\ExternalAccountIdentifiers;
use Imdhemy\GooglePlay\ValueObjects\V2\PausedStateContext;
use Imdhemy\GooglePlay\ValueObjects\V2\SubscribeWithGoogleInfo;
use Imdhemy\GooglePlay\ValueObjects\V2\SubscriptionPurchaseLineItem;
use JsonSerializable;

/**
 * Subscription purchase class
 * A SubscriptionPurchase resource indicates the status of a user's subscription purchase.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2
 */
class SubscriptionPurchaseV2 implements JsonSerializable, GoogleSubscriptionContract
{
    /**
     * @var string|null
     */
    protected $kind;

    /**
     * @var string|null
     */
    protected $regionCode;

    /**
     * @var string|null
     */
    protected $latestOrderId;

    /**
     * @var SubscriptionPurchaseLineItem[]|null
     */
    protected $lineItems;

    /**
     * @var string|null
     */
    protected $startTime;

    /**
     * @var string|null
     */
    protected $subscriptionState;

    /**
     * @var string|null
     */
    protected $linkedPurchaseToken;

    /**
     * @var PausedStateContext|null
     */
    protected $pausedStateContext;

    /**
     * @var CanceledStateContext|null
     */
    protected $canceledStateContext;

    /**
     * @var array|string|bool|null
     */
    protected $testPurchase;

    /**
     * @var string|null
     */
    protected $acknowledgementState;

    /**
     * @var ExternalAccountIdentifiers|null
     */
    protected $externalAccountIdentifiers;

    /**
     * @var SubscribeWithGoogleInfo|null
     */
    protected $subscribeWithGoogleInfo;


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

    public static function fromArray(array $responseBody): self
    {
        return new self($responseBody);
    }

    /**
     * @ return string|null
     */
    public function getKind(): ?string
    {
        return $this->kind;
    }

    public function getRegionCode(): ?string
    {
        return $this->regionCode;
    }

    public function getLatestOrderId(): ?string
    {
        return $this->latestOrderId;
    }

    /**
     * @return SubscriptionPurchaseLineItem[]|null
     */
    public function getLineItems(): ?array
    {
        return $this->lineItems;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function getSubscriptionState(): ?string
    {
        return $this->subscriptionState;
    }

    public function getLinkedPurchaseToken(): ?string
    {
        return $this->linkedPurchaseToken;
    }

    public function getPausedStateContext(): ?PausedStateContext
    {
        return $this->pausedStateContext;
    }

    public function getCanceledStateContext(): ?CanceledStateContext
    {
        return $this->canceledStateContext;
    }

    public function getTestPurchase(): ?bool
    {
        return $this->testPurchase;
    }

    public function getAcknowledgementState(): ?string
    {
        return $this->acknowledgementState;
    }

    public function getExternalAccountIdentifiers(): ?ExternalAccountIdentifiers
    {
        return $this->externalAccountIdentifiers;
    }

    public function getSubscribeWithGoogleInfo(): ?SubscribeWithGoogleInfo
    {
        return $this->subscribeWithGoogleInfo;
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
