<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Information related to a prepaid plan.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#prepaidplan
 */
final readonly class PrepaidPlan
{
    public function __construct(
        public ?Time $allowExtendAfterTime = null,
    ) {
    }
}
