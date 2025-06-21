<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

/**
 * Used when users should be refunded a prorated amount they paid for their subscription based on the amount of time
 * remaining in a subscription.
 *
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2/revoke#proratedrefund
 */
final class ProratedRefund
{
    public static function create(): self
    {
        return new self();
    }
}
