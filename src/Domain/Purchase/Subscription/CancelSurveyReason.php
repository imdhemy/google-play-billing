<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

/**
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#cancelsurveyreason
 */
enum CancelSurveyReason: string
{
    case UNSPECIFIED = 'CANCEL_SURVEY_REASON_UNSPECIFIED';
    case NOT_ENOUGH_USAGE = 'CANCEL_SURVEY_REASON_NOT_ENOUGH_USAGE';
    case TECHNICAL_ISSUES = 'CANCEL_SURVEY_REASON_TECHNICAL_ISSUES';
    case COST_RELATED = 'CANCEL_SURVEY_REASON_COST_RELATED';
    case FOUND_BETTER_APP = 'CANCEL_SURVEY_REASON_FOUND_BETTER_APP';
    case OTHERS = 'CANCEL_SURVEY_REASON_OTHERS';
}
