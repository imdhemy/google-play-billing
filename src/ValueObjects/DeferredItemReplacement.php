<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Information related to deferred item replacement.
 *
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#deferreditemreplacement
 */
final readonly class DeferredItemReplacement
{
    public function __construct(
        public string $productId,
    ) {
    }
}
