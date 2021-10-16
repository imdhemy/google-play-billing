<?php


namespace Imdhemy\GooglePlay\Subscriptions;

use Imdhemy\GooglePlay\ValueObjects\AcknowledgementState;
use Imdhemy\GooglePlay\ValueObjects\Cancellation;
use Imdhemy\GooglePlay\ValueObjects\IntroductoryPriceInfo;
use Imdhemy\GooglePlay\ValueObjects\Price;
use Imdhemy\GooglePlay\ValueObjects\PriceChangeState;
use Imdhemy\GooglePlay\ValueObjects\PromotionType;
use Imdhemy\GooglePlay\ValueObjects\PurchaseType;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionPriceChange;
use Imdhemy\GooglePlay\ValueObjects\Time;

class SubscriptionPurchase
{
    /**
     * @var string
     */
    protected $kind;

    /**
     * @var int
     */
    protected $startTimeMillis;

    /**
     * @var int
     */
    protected $expiryTimeMillis;

    /**
     * @var int
     */
    protected $autoResumeTimeMillis;

    /**
     * @var bool
     */
    protected $autoRenewing;

    /**
     * @var string
     */
    protected $priceCurrencyCode;

    /**
     * @var int
     */
    protected $priceAmountMicros;

    /**
     * @var array
     */
    protected $introductoryPriceInfo;

    /**
     * @var string
     */
    protected $countryCode;

    /**
     * @var string
     */
    protected $developerPayload;

    /**
     * @var int
     */
    protected $paymentState;

    /**
     * @var int
     */
    protected $cancelReason;

    /**
     * @var int
     */
    protected $userCancellationTimeMillis;

    /**
     * @var array
     */
    protected $cancelSurveyResult;

    /**
     * @var string
     */
    protected $orderId;

    /**
     * @var string
     */
    protected $linkedPurchaseToken;

    /**
     * @var int
     */
    protected $purchaseType;

    /**
     * @var array
     */
    protected $priceChange;

    /**
     * @var string
     */
    protected $emailAddress;

    /**
     * @var string
     */
    protected $givenName;

    /**
     * @var string
     */
    protected $profileId;

    /**
     * @var int
     */
    protected $acknowledgementState;

    /**
     * @var string
     */
    protected $externalAccountId;

    /**
     * @var int
     */
    protected $promotionType;

    /**
     * @var string
     */
    protected $promotionCode;

    /**
     * @var string
     */
    protected $obfuscatedExternalAccountId;

    /**
     * @var string
     */
    protected $obfuscatedExternalProfileId;

    /**
     * @param array $responseBody
     * @return self
     */
    public static function fromResponseBody(array $responseBody): self
    {
        $object = new self();

        $attributes = array_keys(get_class_vars(self::class));
        foreach ($attributes as $attribute) {
            if (isset($responseBody[$attribute])) {
                $object->$attribute = $responseBody[$attribute];
            }
        }

        return $object;
    }

    /**
     * @return string
     */
    public function getKind(): string
    {
        return $this->kind;
    }

    /**
     * @return bool
     */
    public function isAutoRenewing(): bool
    {
        return $this->autoRenewing;
    }

    /**
     * @return string
     */
    public function getPriceCurrencyCode(): string
    {
        return $this->priceCurrencyCode;
    }

    /**
     * @return int
     */
    public function getPriceAmountMicros(): int
    {
        return $this->priceAmountMicros;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getDeveloperPayload(): string
    {
        return $this->developerPayload;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getLinkedPurchaseToken(): ?string
    {
        return $this->linkedPurchaseToken;
    }

    /**
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    /**
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    /**
     * @return string
     */
    public function getProfileId(): string
    {
        return $this->profileId;
    }

    /**
     * @return string
     */
    public function getExternalAccountId(): string
    {
        return $this->externalAccountId;
    }

    /**
     * @return string
     */
    public function getObfuscatedExternalAccountId(): string
    {
        return $this->obfuscatedExternalAccountId;
    }

    /**
     * @return string
     */
    public function getObfuscatedExternalProfileId(): string
    {
        return $this->obfuscatedExternalProfileId;
    }

    /**
     * @return Time|null
     */
    public function getStartTime(): ?Time
    {
        return $this->startTimeMillis ? new Time($this->startTimeMillis) : null;
    }

    /**
     * @return Time|null
     */
    public function getExpiryTime(): ?Time
    {
        return $this->expiryTimeMillis ? new Time($this->expiryTimeMillis) : null;
    }

    /**
     * @return Time|null
     */
    public function getAutoResumeTime(): ?Time
    {
        return $this->autoResumeTimeMillis ? new Time($this->autoResumeTimeMillis) : null;
    }

    /**
     * @return IntroductoryPriceInfo
     */
    public function getIntroductoryPriceInfo(): IntroductoryPriceInfo
    {
        return IntroductoryPriceInfo::fromArray($this->introductoryPriceInfo);
    }

    /**
     * @return SubscriptionPriceChange
     */
    public function getPriceChange(): SubscriptionPriceChange
    {
        $newPrice = new Price(...array_values($this->priceChange['newPrice']));
        $state = new PriceChangeState($this->priceChange['state']);

        return new SubscriptionPriceChange($newPrice, $state);
    }

    /**
     * @return Cancellation
     */
    public function getCancellation(): Cancellation
    {
        return Cancellation::fromScalars(
            $this->cancelReason,
            $this->userCancellationTimeMillis,
            $this->cancelSurveyResult
        );
    }

    /**
     * @return PromotionType
     */
    public function getPromotionType(): PromotionType
    {
        return new PromotionType($this->promotionType, $this->promotionCode);
    }

    /**
     * @return AcknowledgementState
     */
    public function getAcknowledgementState(): AcknowledgementState
    {
        return new AcknowledgementState($this->acknowledgementState);
    }

    /**
     * @return int
     */
    public function getPaymentState(): int
    {
        return $this->paymentState;
    }
    
    /**
     * @return PurchaseType
     */
    public function getPurchaseType(): PurchaseType
    {
        return new PurchaseType($this->purchaseType);
    }
}
