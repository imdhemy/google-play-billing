<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

/**
 * Used when a specific item should be refunded in a subscription with add-on items.
 *
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2/revoke#itembasedrefund
 */
final readonly class ItemBasedRefund
{
    public function __construct(public string $productId)
    {
    }

    public static function forProduct(string $productId): self
    {
        return new self($productId);
    }
}
