<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Offer details information related to a purchase line item.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#offerdetails
 */
final readonly class OfferDetails
{
    /**
     * @param string[] $offerTags
     */
    public function __construct(
        public array $offerTags,
        public string $basePlanId,
        public ?string $offerId = null
    ) {
    }
}
