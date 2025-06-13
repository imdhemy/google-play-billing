<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Revocation context of the purchases.subscriptionsv2.revoke API.
 *
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2/revoke#revocationcontext
 */
final readonly class RevocationContext
{
    private function __construct(
        public ?FullRefund $fullRefund = null,
        public ?ProratedRefund $proratedRefund = null,
        public ?ItemBasedRefund $itemBasedRefund = null,
    ) {
    }

    public static function fullRefund(): self
    {
        return new self(fullRefund: FullRefund::create());
    }

    public static function proratedRefund(): self
    {
        return new self(proratedRefund: ProratedRefund::create());
    }

    public static function itemBasedRefund(string $productId): self
    {
        return new self(itemBasedRefund: ItemBasedRefund::forProduct($productId));
    }
}
