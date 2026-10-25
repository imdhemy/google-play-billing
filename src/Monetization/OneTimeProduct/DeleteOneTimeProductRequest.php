<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\OneTimeProduct;

use Imdhemy\GooglePlay\ValueObjects\ProductUpdateLatencyTolerance;
use JsonSerializable;

/**
 * Request message for deleting a one-time product.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/monetization.onetimeproducts/batchDelete#DeleteOneTimeProductRequest
 */
final readonly class DeleteOneTimeProductRequest implements JsonSerializable
{
    /**
     * @param string                             $packageName      the parent app (package name) of the one-time product to delete
     * @param string                             $productId        the one-time product ID of the one-time product to delete
     * @param ProductUpdateLatencyTolerance|null $latencyTolerance the latency tolerance for the propagation of this product update, latency-sensitive when omitted
     */
    public function __construct(
        public string $packageName,
        public string $productId,
        public ?ProductUpdateLatencyTolerance $latencyTolerance = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'packageName' => $this->packageName,
            'productId' => $this->productId,
            'latencyTolerance' => $this->latencyTolerance?->value,
        ], static fn (mixed $value): bool => null !== $value);
    }
}
