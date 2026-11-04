<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * Address information for the customer, for use in tax computation.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#buyeraddress
 */
final readonly class BuyerAddress
{
    /**
     * @param string|null $buyerPostcode Postal code of the buyer address
     * @param string|null $buyerState    Top-level administrative subdivision of the buyer address country
     * @param string|null $buyerCountry  Two-letter ISO-3166-1 Alpha-2 country code
     */
    public function __construct(
        public ?string $buyerPostcode = null,
        public ?string $buyerState = null,
        public ?string $buyerCountry = null,
    ) {
    }
}
