<?php


namespace Imdhemy\GooglePlay\ValueObjects;

final class Cancellation
{
    /**
     * @var CancelReason|null
     */
    private $cancelReason;

    /**
     * @var Time|null
     */
    private $userCancellationTime;

    /**
     * @var SubscriptionCancelSurveyResult|null
     */
    private $cancelSurveyResult;

    /**
     * Cancellation constructor.
     * @param CancelReason|null $cancelReason
     * @param Time|null $userCancellationTime
     * @param SubscriptionCancelSurveyResult|null $cancelSurveyResult
     */
    public function __construct(
        ?CancelReason $cancelReason,
        ?Time $userCancellationTime,
        ?SubscriptionCancelSurveyResult $cancelSurveyResult
    ) {
        $this->cancelReason = $cancelReason;
        $this->userCancellationTime = $userCancellationTime;
        $this->cancelSurveyResult = $cancelSurveyResult;
    }

    /**
     * @param int|null $cancelReason
     * @param int|null $userCancellationTimeMillis
     * @param array|null $cancelSurveyResult
     * @return static
     */
    public static function fromScalars(
        ?int $cancelReason,
        ?int $userCancellationTimeMillis,
        ?array $cancelSurveyResult
    ): self {
        $cancelReason = is_null($cancelReason) ? null : new CancelReason($cancelReason);
        $userCancellationTime = is_null($userCancellationTimeMillis) ? null : new Time($userCancellationTimeMillis);
        $cancelSurveyResult = is_null($cancelSurveyResult) ? null : SubscriptionCancelSurveyResult::fromScalars(
            ...$cancelSurveyResult
        );

        return new self($cancelReason, $userCancellationTime, $cancelSurveyResult);
    }

    /**
     * @return bool
     */
    public function isCancelled(): bool
    {
        return ! is_null($this->cancelReason);
    }

    /**
     * @return CancelReason|null
     */
    public function getCancelReason(): ?CancelReason
    {
        return $this->cancelReason;
    }

    /**
     * @return Time|null
     */
    public function getUserCancellationTime(): ?Time
    {
        return $this->userCancellationTime;
    }

    /**
     * @return SubscriptionCancelSurveyResult|null
     */
    public function getCancelSurveyResult(): ?SubscriptionCancelSurveyResult
    {
        return $this->cancelSurveyResult;
    }

    /**
     * @return static
     */
    public static function fake(): self
    {
        return new self(CancelReason::fake(), Time::fake(), SubscriptionCancelSurveyResult::fake());
    }
}
