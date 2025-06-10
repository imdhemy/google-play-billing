<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Information related to an auto renewing plan.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#autorenewingplan
 */
final readonly class AutoRenewingPlan
{
    public function __construct(
        public bool $autoRenewEnabled,
        public Money $recurringPrice,
        public SubscriptionItemPriceChangeDetails $priceChangeDetails,
        public InstallmentPlan $installmentDetails,
    ) {
    }
}
