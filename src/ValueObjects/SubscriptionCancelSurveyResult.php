<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Subscription Cancel Survey Result
 *
 * Information provided by the user when
 * they complete the subscription cancellation flow (cancellation reason survey).
 *
 * @link https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptions#SubscriptionCancelSurveyResult
 */
final class SubscriptionCancelSurveyResult
{
    public const CANCEL_SURVEY_REASON_OTHER = 0;
    public const CANCEL_SURVEY_REASON_NOT_USING_ENOUGH = 1;
    public const CANCEL_SURVEY_REASON_TECHNICAL_ISSUES = 2;
    public const CANCEL_SURVEY_REASON_COST_RELATED = 3;
    public const CANCEL_SURVEY_REASON_FOUND_BETTER_APP = 4;

    public const ATTR_CANCEL_SURVEY_REASON = 'cancelSurveyReason';
    public const ATTR_USER_INPUT_CANCEL_REASON = 'userInputCancelReason';

    /**
     * The cancellation reason the user chose in the survey.
     * @var int
     */
    private $cancelSurveyReason;

    /**
     * The customized input cancel reason from the user.
     * @var string|null
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
     * @param array $attributes
     * @return static
     */
    public static function fromArray(array $attributes): self
    {
        $reason = $attributes[self::ATTR_CANCEL_SURVEY_REASON];
        $userInput = $attributes[self::ATTR_USER_INPUT_CANCEL_REASON] ?? null;

        return new self($reason, $userInput);
    }

    /**
     * @return int
     */
    public function getCancelSurveyReason(): int
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
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::ATTR_CANCEL_SURVEY_REASON => $this->getCancelSurveyReason(),
            self::ATTR_USER_INPUT_CANCEL_REASON => $this->getUserInputCancelReason(),
        ];
    }
}
