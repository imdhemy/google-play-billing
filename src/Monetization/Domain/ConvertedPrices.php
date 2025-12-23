<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Domain;

use Imdhemy\GooglePlay\ValueObjects\RegionsVersion;

/**
 *  represents the response of the convertRegionPrices method in the monetization API.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/monetization/convertRegionPrices#response-body
 */
final readonly class ConvertedPrices
{
    /**
     * @param array<string, ConvertedRegionPrice> $convertedRegionPrices
     */
    public function __construct(
        public array $convertedRegionPrices,
        public ConvertedOtherRegionsPrice $convertedOtherRegionsPrice,
        public RegionsVersion $regionVersion,
    ) {
    }
}
