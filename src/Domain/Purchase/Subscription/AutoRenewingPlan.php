<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\ValueObjects\Money;

/**
 * Information related to an auto renewing plan.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#autorenewingplan
 */
final readonly class AutoRenewingPlan
{
    public function __construct(
        public Money $recurringPrice,
        public ?bool $autoRenewEnabled = false,
        public ?SubscriptionItemPriceChangeDetails $priceChangeDetails = null,
        public ?InstallmentPlan $installmentDetails = null,
    ) {
    }
}
