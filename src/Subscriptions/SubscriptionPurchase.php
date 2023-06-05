<?php

namespace Imdhemy\GooglePlay\Subscriptions;

use Imdhemy\GooglePlay\ValueObjects\Cancellation;
use Imdhemy\GooglePlay\ValueObjects\IntroductoryPriceInfo;
use Imdhemy\GooglePlay\ValueObjects\Price;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionPriceChange;
use Imdhemy\GooglePlay\ValueObjects\Time;
use JsonSerializable;

/**
 * Subscription purchase class
 * A SubscriptionPurchase resource indicates the status of a user's subscription purchase.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptions#SubscriptionPurchase
 */
class SubscriptionPurchase implements JsonSerializable
{
    public const PURCHASE_TYPE_TEST = 0;
    public const PURCHASE_TYPE_PROMO = 1;

    public const ACKNOWLEDGEMENT_STATE_NOT_ACKNOWLEDGED = 0;
    public const ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED = 1;

    public const PROMOTION_TYPE_VANITY_CODE = 1;
    public const PROMOTION_TYPE_ONE_TIME_CODE = 0;

    public const PAYMENT_STATE_FREE_TRIAL = 2;
    public const PAYMENT_STATE_PENDING = 0;
    public const PAYMENT_STATE_DEFERRED = 3;
    public const PAYMENT_STATE_RECEIVED = 1;

    /**
     * @var string|null
     */
    protected $kind;

    /**
     * @var int|null
     */
    protected $startTimeMillis;

    /**
     * @var int|null
     */
    protected $expiryTimeMillis;

    /**
     * @var int|null
     */
    protected $autoResumeTimeMillis;

    /**
     * @var bool|null
     */
    protected $autoRenewing;

    /**
     * @var string|null
     */
    protected $priceCurrencyCode;

    /**
     * @var int|null
     */
    protected $priceAmountMicros;

    /**
     * @var array|null
     */
    protected $introductoryPriceInfo;

    /**
     * @var string|null
     */
    protected $countryCode;

    /**
     * @var string|null
     */
    protected $developerPayload;

    /**
     * @var int|null
     */
    protected $paymentState;

    /**
     * @var int|null
     */
    protected $cancelReason;

    /**
     * @var int|null
     */
    protected $userCancellationTimeMillis;

    /**
     * @var array|null
     */
    protected $cancelSurveyResult;

    /**
     * @var string|null
     */
    protected $orderId;

    /**
     * @var string|null
     */
    protected $linkedPurchaseToken;

    /**
     * @var int|null
     */
    protected $purchaseType;

    /**
     * @var array|null
     */
    protected $priceChange;

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
     * @var string|null
     */
    protected $profileId;

    /**
     * @var int|null
     */
    protected $acknowledgementState;

    /**
     * @var string|null
     */
    protected $externalAccountId;

    /**
     * @var int|null
     */
    protected $promotionType;

    /**
     * @var string|null
     */
    protected $promotionCode;

    /**
     * @var string|null
     */
    protected $obfuscatedExternalAccountId;

    /**
     * @var string|null
     */
    protected $obfuscatedExternalProfileId;

    /**
     * @var array
     */
    protected $plainResponse;

    /**
     * Subscription Purchase Constructor.
     */
    public function __construct(array $responseBody = [])
    {
        $attributes = array_keys(get_class_vars(self::class));

        foreach ($attributes as $attribute) {
            if (isset($responseBody[$attribute])) {
                $this->$attribute = $responseBody[$attribute];
            }
        }

        $this->plainResponse = $responseBody;
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

    /**
     * @ return bool|null
     */
    public function isAutoRenewing(): ?bool
    {
        return $this->autoRenewing;
    }

    /**
     * @ return string|null
     */
    public function getPriceCurrencyCode(): ?string
    {
        return $this->priceCurrencyCode;
    }

    /**
     * @ return int|null
     */
    public function getPriceAmountMicros(): ?int
    {
        return $this->priceAmountMicros;
    }

    /**
     * @ return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @ return string|null
     */
    public function getDeveloperPayload(): ?string
    {
        return $this->developerPayload;
    }

    /**
     * @ return string|null
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * @ return string|null
     */
    public function getLinkedPurchaseToken(): ?string
    {
        return $this->linkedPurchaseToken;
    }

    /**
     * @ return string|null
     */
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    /**
     * @ return string|null
     */
    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    /**
     * @ return string|null
     */
    public function getProfileId(): ?string
    {
        return $this->profileId;
    }

    /**
     * @ return string|null
     */
    public function getExternalAccountId(): ?string
    {
        return $this->externalAccountId;
    }

    /**
     * @ return string|null
     */
    public function getObfuscatedExternalAccountId(): ?string
    {
        return $this->obfuscatedExternalAccountId;
    }

    /**
     * @ return string|null
     */
    public function getObfuscatedExternalProfileId(): ?string
    {
        return $this->obfuscatedExternalProfileId;
    }

    public function getStartTime(): ?Time
    {
        return is_null($this->startTimeMillis) ? null : new Time($this->startTimeMillis);
    }

    public function getExpiryTime(): ?Time
    {
        return is_null($this->expiryTimeMillis) ? null : new Time($this->expiryTimeMillis);
    }

    public function getAutoResumeTime(): ?Time
    {
        return is_null($this->autoResumeTimeMillis) ? null : new Time($this->autoResumeTimeMillis);
    }

    public function getIntroductoryPriceInfo(): ?IntroductoryPriceInfo
    {
        return is_null($this->introductoryPriceInfo) ?
            null :
            IntroductoryPriceInfo::fromArray($this->introductoryPriceInfo);
    }

    public function getPriceChange(): ?SubscriptionPriceChange
    {
        if (is_null($this->priceChange)) {
            return null;
        }

        $newPrice = Price::fromArray($this->priceChange['newPrice']);
        $state = $this->priceChange['state'];

        return new SubscriptionPriceChange($newPrice, $state);
    }

    public function getCancellation(): ?Cancellation
    {
        $noCancellationData =
            is_null($this->cancelReason)
            && is_null($this->userCancellationTimeMillis)
            && is_null($this->cancelSurveyResult);

        if ($noCancellationData) {
            return null;
        }

        return Cancellation::fromArray([
            Cancellation::ATTR_CANCEL_REASON => $this->cancelReason,
            Cancellation::ATTR_USER_CANCELLATION_TIME_MILLIS => $this->userCancellationTimeMillis,
            Cancellation::ATTR_cancelSurveyResult => $this->cancelSurveyResult,
        ]);
    }

    public function getAcknowledgementState(): ?int
    {
        return $this->acknowledgementState;
    }

    public function getPaymentState(): ?int
    {
        return $this->paymentState;
    }

    public function getPurchaseType(): ?int
    {
        return $this->purchaseType;
    }

    public function getProfileName(): ?string
    {
        return $this->profileName;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function getPlainResponse(): array
    {
        return $this->plainResponse;
    }

    public function toArray(): array
    {
        return $this->getPlainResponse();
    }

    public function getPromotionType(): ?int
    {
        return $this->promotionType;
    }

    public function getPromotionCode(): ?string
    {
        return $this->promotionCode;
    }

    public function getStartTimeMillis(): ?int
    {
        return $this->startTimeMillis;
    }

    public function getExpiryTimeMillis(): ?int
    {
        return $this->expiryTimeMillis;
    }

    public function getAutoResumeTimeMillis(): ?int
    {
        return $this->autoResumeTimeMillis;
    }

    public function getAutoRenewing(): ?bool
    {
        return $this->autoRenewing;
    }

    public function getCancelReason(): ?int
    {
        return $this->cancelReason;
    }

    public function getUserCancellationTimeMillis(): ?int
    {
        return $this->userCancellationTimeMillis;
    }

    public function getCancelSurveyResult(): ?array
    {
        return $this->cancelSurveyResult;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
