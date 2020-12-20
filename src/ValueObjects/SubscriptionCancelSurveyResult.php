<?php


namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Class SubscriptionCancelSurveyResult
 * @package Imdhemy\GooglePlay\ValueObjects
 */
final class SubscriptionCancelSurveyResult
{
    /**
     * @var CancelSurveyReason
     */
    private $cancelSurveyReason;

    /**
     * @var string
     */
    private $userInputCancelReason;

    /**
     * SubscriptionCancelSurveyResult constructor.
     * @param CancelSurveyReason $cancelSurveyReason
     * @param string|null $userInputCancelReason
     */
    public function __construct(CancelSurveyReason $cancelSurveyReason, ?string $userInputCancelReason = null)
    {
        $this->cancelSurveyReason = $cancelSurveyReason;
        $this->userInputCancelReason = $userInputCancelReason;
    }

    /**
     * @param int $cancelSurveyReason
     * @param string|null $userInputCancelReason
     * @return static
     */
    public static function fromScalars(int $cancelSurveyReason, ?string $userInputCancelReason = null): self
    {
        return new self(
            new CancelSurveyReason($cancelSurveyReason),
            $userInputCancelReason
        );
    }

    /**
     * @return CancelSurveyReason
     */
    public function getCancelSurveyReason(): CancelSurveyReason
    {
        return $this->cancelSurveyReason;
    }

    /**
     * @return string|null
     */
    public function getUserInputCancelReason(): ?string
    {
        return $this->userInputCancelReason;
    }

    /**
     * @param CancelSurveyReason|null $cancelSurveyReason
     * @param string|null $userInputCancelReason
     * @return static
     */
    public static function fake(
        ?CancelSurveyReason $cancelSurveyReason = null,
        ?string $userInputCancelReason = null
    ): self {
        $reason = $cancelSurveyReason ?? CancelSurveyReason::fake();

        return new self($reason, $userInputCancelReason);
    }
}
