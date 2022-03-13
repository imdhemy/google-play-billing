<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Cancellation
 *
 * Cancellation object contains data about the cancellation, including:
 * - cancel reason
 * - user cancellation time
 * - cancel survey result
 */
final class Cancellation
{
    public const CANCEL_REASON_BY_USER = 0;
    public const CANCEL_REASON_BY_SYSTEM = 1;
    public const CANCEL_REASON_REPLACED = 2;
    public const CANCEL_REASON_BY_DEVELOPER = 3;

    public const ATTR_CANCEL_REASON = 'cancelReason';
    public const ATTR_USER_CANCELLATION_TIME_MILLIS = 'userCancellationTimeMillis';
    public const ATTR_cancelSurveyResult = 'cancelSurveyResult';

    /**
     * The reason why a subscription was canceled or is not auto-renewing.
     * @var int|null
     */
    private $cancelReason;

    /**
     * @var string|null
     */
    private $userCancellationTime;

    /**
     * @var array|null
     */
    private $cancelSurveyResult;

    /**
     * Cancellation constructor.
     * @param int|null $cancelReason
     * @param string|null $userCancellationTime
     * @param array|null $cancelSurveyResult
     */
    public function __construct(?int $cancelReason, ?string $userCancellationTime, ?array $cancelSurveyResult)
    {
        $this->cancelReason = $cancelReason;
        $this->userCancellationTime = $userCancellationTime;
        $this->cancelSurveyResult = $cancelSurveyResult;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function fromArray(array $attributes = []): self
    {
        $cancelReason = $attributes[self::ATTR_CANCEL_REASON] ?? null;
        $userCancellationTimeMillis = $attributes[self::ATTR_USER_CANCELLATION_TIME_MILLIS] ?? null;
        $cancelSurveyResult = $attributes[self::ATTR_cancelSurveyResult] ?? null;

        return new self($cancelReason, $userCancellationTimeMillis, $cancelSurveyResult);
    }

    /**
     * @return bool
     */
    public function isCancelled(): bool
    {
        return ! is_null($this->cancelReason);
    }

    /**
     * @return int|null
     */
    public function getCancelReason(): ?int
    {
        return $this->cancelReason;
    }

    /**
     * @return Time|null
     */
    public function getUserCancellationTime(): ?Time
    {
        return
            is_null($this->userCancellationTime)
                ? null
                : new Time($this->userCancellationTime);
    }

    /**
     * @return SubscriptionCancelSurveyResult|null
     */
    public function getCancelSurveyResult(): ?SubscriptionCancelSurveyResult
    {
        return
            is_null($this->cancelSurveyResult)
                ? null
                : SubscriptionCancelSurveyResult::fromArray($this->cancelSurveyResult);
    }
}
