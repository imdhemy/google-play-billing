<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Domain;

use Imdhemy\GooglePlay\ValueObjects\Money;

/**
 * Represents the converted other region price.
 *
 * {@link https://developers.google.com/android-publisher/api-ref/rest/v3/monetization/convertRegionPrices#ConvertedOtherRegionsPrice}
 */
final readonly class ConvertedOtherRegionsPrice
{
    public function __construct(
        public Money $usdPrice,
        public Money $eurPrice,
    ) {
    }
}
