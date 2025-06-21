<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

/**
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#cancelsurveyresult
 */
final readonly class CancelSurveyResult
{
    public function __construct(
        public CancelSurveyReason $reason,
        public ?string $reasonUserInput = null,
    ) {
    }
}
