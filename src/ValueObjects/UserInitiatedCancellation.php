<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#userinitiatedcancellation
 */
final readonly class UserInitiatedCancellation
{
    public function __construct(
        public CancelSurveyResult $cancelSurveyResult,
        public Time $cancelTime,
    ) {
    }
}
