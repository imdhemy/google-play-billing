<?php


namespace Imdhemy\GooglePlay\ValueObjects;


final class SubscriptionCancelSurveyResult
{
    private $cancelSurveyReason;

    private $userInputCancelReason;

    public function __construct($cancelSurveyReason, $userInputCancelReason)
    {
        $this->cancelSurveyReason = $cancelSurveyReason;
        $this->userInputCancelReason = $userInputCancelReason;
    }
}
