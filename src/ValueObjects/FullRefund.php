<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Used when users should be refunded the full amount of latest charge on each item in the subscription.
 *
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2/revoke#fullrefund
 */
final class FullRefund
{
    public static function create(): self
    {
        return new self();
    }
}
