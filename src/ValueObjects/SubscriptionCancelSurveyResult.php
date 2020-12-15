<?php


namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Class SubscriptionCancelSurveyResult
 * @package Imdhemy\GooglePlay\ValueObjects
 */
final class SubscriptionCancelSurveyResult
{
    /**
     * @var int
     */
    private $cancelSurveyReason;

    /**
     * @var string
     */
    private $userInputCancelReason;

    /**
     * SubscriptionCancelSurveyResult constructor.
     * @param int $cancelSurveyReason
     * @param string|null $userInputCancelReason
     */
    public function __construct(int $cancelSurveyReason, ?string $userInputCancelReason = null)
    {
        $this->cancelSurveyReason = $cancelSurveyReason;
        $this->userInputCancelReason = $userInputCancelReason;
    }

    /**
     * @return CancelSurveyReason
     */
    public function getCancelSurveyReason(): CancelSurveyReason
    {
        return new CancelSurveyReason($this->cancelSurveyReason);
    }

    /**
     * @return string|null
     */
    public function getUserInputCancelReason(): ?string
    {
        return $this->userInputCancelReason;
    }
}
