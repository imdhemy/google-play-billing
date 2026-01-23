<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application;

use Imdhemy\GooglePlay\Domain\Serializer\NormalizerInterface;
use Imdhemy\GooglePlay\Monetization\Application\Query\ConvertRegionPricesQuery;
use Imdhemy\GooglePlay\Monetization\Domain\ConvertedPrices;
use Psr\Http\Client\ClientInterface;
use Throwable;

final readonly class ConvertRegionPrices
{
    public function __construct(
        private ClientInterface $client,
        private MonetizationRequestFactoryInterface $requestFactory,
        private NormalizerInterface $normalizer,
    ) {
    }

    /**
     * Convert region prices into different regions.
     *
     * @throws MonetizationException
     */
    public function execute(ConvertRegionPricesQuery $query): ConvertedPrices
    {
        try {
            $request = $this->requestFactory->create($query);
            $response = $this->client->sendRequest($request);
        } catch (Throwable $e) {
            throw MonetizationException::conversionFailed(previous: $e);
        }

        return $this->normalizer->normalize(data: $response, type: ConvertedPrices::class);
    }
}
