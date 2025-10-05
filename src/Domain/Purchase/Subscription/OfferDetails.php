<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

/**
 * Offer details information related to a purchase line item.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#offerdetails
 */
final readonly class OfferDetails
{
    /**
     * @param string[]|null $offerTags
     */
    public function __construct(
        public string $basePlanId,
        public ?array $offerTags = null,
        public ?string $offerId = null,
    ) {
    }
}
