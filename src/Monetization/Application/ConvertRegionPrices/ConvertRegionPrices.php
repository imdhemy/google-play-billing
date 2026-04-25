<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices;

use Imdhemy\GooglePlay\Domain\Serializer\NormalizerInterface;
use Imdhemy\GooglePlay\Monetization\Application\MonetizationRequestFactoryInterface;
use Imdhemy\GooglePlay\Monetization\Domain\ConvertedPrices;
use Psr\Http\Client\ClientInterface;
use Throwable;

/**
 * Calculates the region prices, using today's exchange rate and country-specific pricing patterns, based on the price
 * in the request for a set of regions.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/monetization/convertRegionPrices#convertedotherregionsprice
 */
final readonly class ConvertRegionPrices
{
    public function __construct(
        private ClientInterface $client,
        private MonetizationRequestFactoryInterface $requestFactory,
        private NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @throws ConvertRegionPricesException
     */
    public function execute(ConvertRegionPricesQuery $query): ConvertedPrices
    {
        try {
            $request = $this->requestFactory->createConvertRegionPricesRequest($query);
            $response = $this->client->sendRequest($request);

            return $this->normalizer->normalize(data: $response, type: ConvertedPrices::class);
        } catch (Throwable $e) {
            throw ConvertRegionPricesException::failed(previous: $e);
        }
    }
}
