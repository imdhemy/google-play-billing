<?php


namespace Imdhemy\GooglePlay\ValueObjects;

final class Cancellation
{
    /**
     * @var int|null
     */
    private $cancelReason;

    /**
     * @var int|null
     */
    private $userCancellationTimeMillis;

    /**
     * @var array|null
     */
    private $cancelSurveyResult;

    /**
     * Cancellation constructor.
     * @param int|null $cancelReason
     * @param int|null $userCancellationTimeMillis
     * @param array|null $cancelSurveyResult
     */
    public function __construct(
        ?int $cancelReason = null,
        ?int $userCancellationTimeMillis = null,
        ?array $cancelSurveyResult = null
    ) {
        $this->cancelReason = $cancelReason;
        $this->userCancellationTimeMillis = $userCancellationTimeMillis;
        $this->cancelSurveyResult = $cancelSurveyResult;
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
        return is_null($this->cancelReason) ? null : new CancelReason($this->cancelReason);
    }

    /**
     * @return Time|null
     */
    public function getUserCancellationTime(): ?Time
    {
        return is_null($this->userCancellationTimeMillis) ? null : new Time($this->userCancellationTimeMillis);
    }

    /**
     * @return array|null
     */
    public function getCancelSurveyResult(): ?SubscriptionCancelSurveyResult
    {
        return is_null($this->cancelSurveyResult) ?
            null : SubscriptionCancelSurveyResult::fromScalars(...$this->cancelSurveyResult);
    }
}
